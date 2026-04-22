<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use DB;

class LoginController extends BaseController
{
    // ─────────────────────────────────────────
    //  LOGIN PAGE
    // ─────────────────────────────────────────
    public function login()
    {
      try {
        DB::connection()->getPdo();
    } catch (PDOException $e) {
        dd($e);
        return response()->view('errors.db', [
            'message' => 'Database connection failed (Oracle)' . $e 
        ], 500);
    } catch (\Exception $e) {
        return response()->view('errors.db', [
            'message' => 'System unavailable' .$e 
        ], 500);
    }

    // ✅ Existing session check
    if (session('LoggedUser')) {
        return redirect('dashboard');
    }

    return view('auth.loginuser');
    }

    // ─────────────────────────────────────────
    //  AUTHENTICATE
    // ─────────────────────────────────────────
       public function check(Request $request)
    {
        $request->validate([
            'user_id'          => 'required',
            'initial_password' => 'required',
        ]);

        $oracleUser = Str::upper($request->user_id);
        $oraclePass = $request->initial_password;

        // ── Step 1: Validate credentials against Oracle ──────────────
        if (!$this->validateOracleCredentials($oracleUser, $oraclePass)) {
            return back()->with('fail', 'Invalid UserName or Password');
        }

        // ── Step 2: Load app user profile from User model ─────────────
        $user = User::where('user_id', $oracleUser)->first();

        if (!$user) {
            return back()->with('fail', 'User account not found in the system');
        }elseif($user->user_status == 'L'){
                        return back()->with('fail', 'User account is Locked . Please Contact Administrator');

        }
        // ── Step 3: Log in & set session ──────────────────────────────
        Auth::guard('web')->login($user);
        $request->session()->regenerate();

        session([
            'LoggedUser' => $user->employee_id,
            'LoggedId'   => $user->user_id,
        ]);

        return redirect('/dashboard');
    }

    // ─────────────────────────────────────────
    //  ORACLE CREDENTIAL VALIDATOR
    //  Attempts a real Oracle connection using
    //  the supplied username & password.
    //  Returns true on success, false on failure.
    // ─────────────────────────────────────────
    private function validateOracleCredentials(string $username, string $password): bool
    {
        // Pull base config from your default Oracle connection
        $baseConfig = config('database.connections.oracle'); // adjust key if needed

        $testConfig = array_merge($baseConfig, [
            'username' => $username,
            'password' => $password,
            // Give it a unique name so it doesn't collide with the default connection
            'driver'   => $baseConfig['driver'] ?? 'oracle',
        ]);

        // Register a temporary connection
        config(['database.connections.oracle_auth_test' => $testConfig]);

        try {
            $pdo = DB::connection('oracle_auth_test')->getPdo();

            // Optionally confirm the schema user exists and is not locked
            // SELECT 1 FROM dual is the lightest possible Oracle query
            DB::connection('oracle_auth_test')->select('SELECT 1 FROM dual');

            return true;
        } catch (\Exception $e) {
            // ORA-01017 = invalid username/password
            // ORA-28000 = account locked
            // Any exception means auth failed
            \Log::warning('Oracle auth failed for user: ' . $username, [
                'error' => $e->getMessage(),
            ]);
            return false;
        } finally {
            // Always clean up the temporary connection
            DB::purge('oracle_auth_test');
            config(['database.connections.oracle_auth_test' => null]);
        }
    }

    // ─────────────────────────────────────────
    //  DASHBOARD
    //  Sidebar data is now shared automatically
    //  by BaseController — no need to re-query.
    // ─────────────────────────────────────────
    public function dashboard()
    {
        if (!session('LoggedUser')) {
            return redirect('login');
        }

        // Dashboard-specific queries only
        $wmpCountData = DB::table(DB::raw('HRM.EMP_PERSONAL Ep'))
            ->select(DB::raw('COUNT(EO.EMPNO) EMPNO'), 'EO.DEPT_NAME')
            ->crossJoin(DB::raw('HRM.EMP_OFFICIAL EO'))
            ->whereRaw('EO.EMPNO = Ep.EMPNO')
            ->where('Ep.STATUS', '=', 'Active')
            ->where('EO.COMPANY_ID', '=', '100')
            ->groupBy('EO.DEPT_NAME')
            ->get();

        $dailyOT = DB::table('ATTD_OT_GROUP_VW')->get();

        $dailyAttdSum = DB::table(DB::raw('attendance_details ad'))
            ->select('EP.SEX', DB::raw('COUNT(eo.empno) total_emp'))
            ->crossJoin(DB::raw('emp_official eo'))
            ->crossJoin(DB::raw('emp_personal ep'))
            ->whereRaw('eo.empno = ad.empno')
            ->whereRaw('ep.empno = eo.empno')
            ->where('AD.ATT_DATE', '=', '2023-04-08')
            ->where('eo.company_id', '=', '100')
            ->groupBy(['eo.company_id', 'EP.SEX'])
            ->get();

        $empCountData = '';
        foreach ($wmpCountData as $row) {
            $empCountData .= "['{$row->dept_name}',{$row->empno}],";
        }

        $empOTData = '';
        foreach ($dailyOT as $row) {
            $empOTData .= "['{$row->a_date}',{$row->c_hour}],";
        }

        $empATTDData = '';
        foreach ($dailyAttdSum as $row) {
            $empATTDData .= "['{$row->sex}',{$row->total_emp}],";
        }

        return view('dashboard', [
            'empATTDData'  => $empATTDData,
            'empOTData'    => $empOTData,
            'empCountData' => $empCountData,
            'expusd'       => '',
        ]);
        // NOTE: $data, $menu, $submenu, $submenu2, $headeer
        // are already shared by BaseController — no need to pass them here.
    }

    // ─────────────────────────────────────────
    //  LOGOUT
    // ─────────────────────────────────────────
    public function logout()
    {
        session()->pull('LoggedUser');
        session()->pull('LoggedId');
        Auth::logout();
        return redirect('login');
    }
}