<?php

namespace App\Http\Controllers\Accounts;
use App\Models\Accounts\VoucherMaster;
use App\Models\Accounts\VoucherDetail;
use App\Models\Accounts\ChartOfAccount;
use App\Models\Accounts\CompanyProfile;
use App\Services\VoucherService;
use App\Http\Requests\VoucherMasterRequest;
use App\Http\Requests\VoucherDetailRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Session;
use DB;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route ;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function __construct(private VoucherService $service) {}

    // ── INDEX ─────────────────────────────────────────────────────
    public function index_old(Request $request)
    {
        $user  = Auth::user()->user_id ?? Auth::user()->username;
        $query = VoucherMaster::with(['company','details'])
            ->where('INSERT_BY', $user);

        if ($s = $request->input('search'))
            $query->where(fn($q) => $q->where('VOUCHER_ID','LIKE','%'.strtoupper(trim($s)).'%')
                                      ->orWhere('RECEIVE_PAY_TO','LIKE','%'.$s.'%'));
        if ($f = $request->input('s_from_date'))  $query->where('VOUCHER_DATE','>=',$f);
        if ($t = $request->input('s_to_date'))    $query->where('VOUCHER_DATE','<=',$t);
        if ($ty = $request->input('voucher_type')) $query->where('VOUCHER_TYPE',$ty);
        if ($st = $request->input('status'))       $query->where('ENTRY_STATUS',$st);

        $vouchers = $query->orderByDesc('VOUCHER_DATE')->paginate(20);

        $stats = [
            'unapproved'  => VoucherMaster::where('INSERT_BY',$user)->where('ENTRY_STATUS','!=','Approved')->count(),
            'approved'    => VoucherMaster::where('INSERT_BY',$user)->where('ENTRY_STATUS','Approved')->count(),
            'total_debit' => DB::selectOne('SELECT NVL(SUM(D.DEBIT_AMOUNT),0) AS tot
                FROM AFM_VOUCHER_DETAIL D JOIN AFM_VOUCHER_MASTER M ON M.VOUCHER_ID=D.VOUCHER_ID
                WHERE M.INSERT_BY=:u', ['u'=>$user])->tot ?? 0,
        ];

        return view('accounts.ventry.voucher.index', compact('vouchers','stats'));
    }

    // ── SUMMARY ───────────────────────────────────────────────────
    public function index(Request $request)
    {
        $user  = Auth::user()->user_id ?? Auth::user()->username;
        $query = VoucherMaster::with(['company','details'])
            ->where('INSERT_BY', $user);

        if ($s  = $request->input('search'))
            $query->where(fn($q) => $q->where('VOUCHER_ID','LIKE','%'.strtoupper(trim($s)).'%')
                                      ->orWhere('RECEIVE_PAY_TO','LIKE','%'.$s.'%'));
        if ($f  = $request->input('s_from_date'))   $query->where('VOUCHER_DATE','>=',$f);
        if ($t  = $request->input('s_to_date'))     $query->where('VOUCHER_DATE','<=',$t);
        if ($ty = $request->input('voucher_type'))  $query->where('VOUCHER_TYPE',$ty);
        if ($st = $request->input('status'))        $query->where('ENTRY_STATUS',$st);
        if ($c  = $request->input('company_id'))    $query->where('COMPANY_ID',$c);

        $vouchers = $query->orderByDesc('VOUCHER_DATE')->paginate(15);

        $allForUser = VoucherMaster::where('INSERT_BY',$user);

        return view('accounts.ventry.voucher.index', [
            'vouchers'       => $vouchers,
            'companies'      => $this->getCompanies(),
            'totalVouchers'  => (clone $allForUser)->count(),
            'unapproved'     => (clone $allForUser)->where('ENTRY_STATUS','!=','Approved')->count(),
            'approved'       => (clone $allForUser)->where('ENTRY_STATUS','Approved')->count(),
            'totalDebit'     => DB::selectOne(
                'SELECT NVL(SUM(D.DEBIT_AMOUNT),0) AS tot
                 FROM AFM_VOUCHER_DETAIL D
                 JOIN AFM_VOUCHER_MASTER M ON M.VOUCHER_ID=D.VOUCHER_ID
                 WHERE M.INSERT_BY=:u', ['u'=>$user]
            )->tot ?? 0,
            'countComplete'  => (clone $allForUser)->where('ENTRY_STATUS','Complete')->count(),
            'countSubmitted' => (clone $allForUser)->where('ENTRY_STATUS','Submited')->count(),
            'countApproved'  => (clone $allForUser)->where('ENTRY_STATUS','Approved')->count(),
        ]);
    }


    // ── AJAX: List with filters (for datatable) ───────────────────────────────
   public function ajaxList(Request $request)
{
    $user  = Auth::user()->user_id ?? Auth::user()->username;

    $query = VoucherMaster::with(['company','details'])
        ->where('INSERT_BY', $user);

    // STATUS (TAB)
    if ($request->status)
        $query->where('ENTRY_STATUS', $request->status);

    // SEARCH
    if ($request->search) {
        $s = strtoupper(trim($request->search));
        $query->where(function($q) use ($s) {
            $q->where('VOUCHER_ID','LIKE',"%$s%")
              ->orWhere('RECEIVE_PAY_TO','LIKE',"%$s%");
        });
    }

    // DATE RANGE
    if ($request->s_from_date)
        $query->where('VOUCHER_DATE','>=',$request->s_from_date);

    if ($request->s_to_date)
        $query->where('VOUCHER_DATE','<=',$request->s_to_date);

    // VOUCHER TYPE
    if ($request->voucher_type)
        $query->where('VOUCHER_TYPE',$request->voucher_type);

    // COMPANY
    if ($request->company_id)
        $query->where('COMPANY_ID',$request->company_id);

    $vouchers = $query->orderByDesc('VOUCHER_DATE')->paginate(10);

    return view('accounts.ventry.voucher.partials.table', compact('vouchers'))->render();
}
//ajaxStats
public function ajaxStats()
{
    $user = Auth::user()->user_id ?? Auth::user()->username;

    $base = VoucherMaster::where('INSERT_BY', $user);

    return response()->json([
        'total'     => (clone $base)->count(),
        'unapproved'=> (clone $base)->where('ENTRY_STATUS','!=','Approved')->count(),
        'approved'  => (clone $base)->where('ENTRY_STATUS','Approved')->count(),
    ]);
}


public function ajaxChart()
{
    $user = Auth::user()->user_id ?? Auth::user()->username;

    $data = DB::select("
        SELECT TO_CHAR(VOUCHER_DATE,'YYYY-MM') as month,
               COUNT(*) as total
        FROM AFM_VOUCHER_MASTER
        WHERE INSERT_BY = :u
        GROUP BY TO_CHAR(VOUCHER_DATE,'YYYY-MM')
        ORDER BY month
    ", ['u'=>$user]);

    return response()->json($data);
}
    // ── CREATE ────────────────────────────────────────────────────
    public function create()
    {
        $user         = Auth::user()->user_id ?? Auth::user()->username;
        $voucherTypes = $this->getVoucherTypes();
        $companies    = $this->getCompanies();

        $defaultCompany = DB::selectOne('SELECT GET_USER_COMPANY(:u) AS c FROM DUAL', ['u'=>$user]);
        $unapprovedCount = DB::selectOne('SELECT GET_COUNT_COM_VOUCHER(:u) AS cnt FROM DUAL', ['u'=>$user]);

        return view('accounts.ventry.voucher.create', [
            'voucherTypes'    => $voucherTypes,
            'companies'       => $companies,
            'defaultCompany'  => $defaultCompany->c ?? null,
            'unapprovedCount' => $unapprovedCount->cnt ?? 0,
        ]);
    }

    // ── STORE ─────────────────────────────────────────────────────
    public function store(VoucherMasterRequest $request)
    {
        try {
            $voucher = $this->service->saveVoucher(
                $request->validated(),
                $request->input('lines', [])
            );
            if ($request->input('_submit_after_save')) {
                $this->service->submitVoucher($voucher);
            }
            return redirect()->route('vouchers.show', $voucher->VOUCHER_ID)
                ->with('success', 'Record(s) successfully saved.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    // ── SHOW ──────────────────────────────────────────────────────
    public function show(string $id)
    {
        $voucher = VoucherMaster::with(['details','company'])->findOrFail($id);

        try {
            $preparedName = DB::selectOne(
                'SELECT ADMIN_PK.GET_USER_EMPLOYEE_NAME(:u) AS n FROM DUAL',
                ['u' => $voucher->PREPARED_BY]
            );
            $voucher->PREPARED_NAME = $preparedName->n ?? $voucher->PREPARED_BY;
        } catch (\Exception) {}

        $amountWord = null;
        try {
            $amountWord = DB::selectOne(
                'SELECT SPEL_OUT(SUM(DEBIT_AMOUNT)) AS words FROM AFM_VOUCHER_DETAIL WHERE VOUCHER_ID=:id',
                ['id' => $id]
            );
        } catch (\Exception) {}

        $approveLabel = $voucher->APPROVED_BY ? 'Approved by '.$voucher->APPROVED_BY : null;
        $updateLabel  = $voucher->UPDATE_BY   ? 'Updated by '.$voucher->UPDATE_BY    : null;

        return view('voucher.show', compact('voucher','approveLabel','updateLabel','amountWord'));
    }

    // ── EDIT ──────────────────────────────────────────────────────
    public function edit(string $id)
    {
        $voucher = VoucherMaster::with('details')->findOrFail($id);
        try { $this->service->beforeUpdateMaster($voucher); }
        catch (\Exception $e) {
            return redirect()->route('vouchers.show',$id)->withErrors(['error'=>$e->getMessage()]);
        }
        return view('voucher.edit', [
            'voucher'      => $voucher,
            'voucherTypes' => $this->getVoucherTypes(),
            'companies'    => $this->getCompanies(),
        ]);
    }

    // ── UPDATE ────────────────────────────────────────────────────
    public function update(VoucherMasterRequest $request, string $id)
    {
        $voucher = VoucherMaster::findOrFail($id);
        try {
            $this->service->beforeUpdateMaster($voucher);
            $voucher->update($request->validated());
            return redirect()->route('vouchers.show',$id)->with('success','Record(s) successfully saved.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error'=>$e->getMessage()]);
        }
    }

    // ── DESTROY ───────────────────────────────────────────────────
    public function destroy(string $id)
    {
        $voucher = VoucherMaster::findOrFail($id);
        try {
            $this->service->beforeDelete($voucher);
            $voucher->details()->delete();
            $voucher->delete();
            return redirect()->route('vouchers.index')->with('success','Voucher deleted.');
        } catch (\Exception $e) {
            return back()->withErrors(['error'=>$e->getMessage()]);
        }
    }

    // ── SUBMIT ────────────────────────────────────────────────────
    public function submit(string $id)
    {
        try {
            $this->service->submitVoucher(VoucherMaster::findOrFail($id));
            return response()->json(['success'=>true,'message'=>'Voucher submitted for approval.']);
        } catch (\Exception $e) {
            return response()->json(['success'=>false,'message'=>$e->getMessage()],422);
        }
    }

    // ── APPROVE ───────────────────────────────────────────────────
    public function approve(string $id)
    {
        try {
            $this->service->approveVoucher(VoucherMaster::findOrFail($id));
            return response()->json(['success'=>true,'message'=>'Voucher approved.']);
        } catch (\Exception $e) {
            return response()->json(['success'=>false,'message'=>$e->getMessage()],422);
        }
    }

    // ── AJAX: account flags ───────────────────────────────────────
    public function accountFlags(Request $request)
    {
        $flags   = $this->service->getAccountFlags($request->account_head_id, $request->company_id);
        $title   = $this->service->getAccountTitle($request->account_head_id, $request->company_id);
        $balance = $this->service->getLedgerBalance($request->account_head_id, $request->company_id);
        return response()->json(array_merge($flags, ['account_title'=>$title,'ledger_balance'=>$balance]));
    }

    // ── AJAX: account LOV ─────────────────────────────────────────
    public function accountLov(Request $request)
    {
        $q       = '%'.strtoupper($request->input('q','')).'%';
        $company = $request->input('company_id');
        $accounts = DB::select(
            "SELECT ACCOUNT_HEAD_ID, ACCOUNT_HEAD_NAME,
                    IS_CREDITOR, IS_DETOR, IS_EMPLOYEE, IS_ASSET, IS_COST_CENTER, IS_LC,
                    GET_AFM_LEDGER_BALANCE_NEW(ACCOUNT_HEAD_ID,:c2) AS BALANCE
             FROM AFM_CHART_OF_ACCOUNTS
             WHERE COMPANY_ID=:c
             AND (UPPER(ACCOUNT_HEAD_ID) LIKE :q OR UPPER(ACCOUNT_HEAD_NAME) LIKE :q2)
             AND ROWNUM<=50 ORDER BY ACCOUNT_HEAD_ID",
            ['c'=>$company,'c2'=>$company,'q'=>$q,'q2'=>$q]
        );
        return response()->json($accounts);
    }

    // ── Helpers ───────────────────────────────────────────────────
    private function getVoucherTypes(): array
    {
        return DB::select(
            'SELECT VOUCHER_TYPE FROM U_VOCUHER WHERE USER_ID=:u',
            ['u' => Auth::user()->user_id ?? Auth::user()->username]
        );
    }

    private function getCompanies(): array
    {
        $u = Auth::user()->user_id ?? Auth::user()->user_id;
        return DB::select(
            "SELECT COMPANY_NAME, COMPANY_ID FROM COMPANY_PROFILE
             WHERE COMPANY_ID IN (
                 SELECT COMPANY_ID FROM COMPANY_PERMISSION
                 WHERE USER_GROUP_ID IN (
                     SELECT P.USER_GROUP_ID FROM USER_PERMISSION P
                     JOIN AUTH_GROUP A ON A.USER_GROUP_ID=P.USER_GROUP_ID
                     WHERE P.USER_ID=:u AND A.GROUP_TYEP='U'))",
            ['u' => $u]
        );
    }
}
