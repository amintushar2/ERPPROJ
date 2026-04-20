<?php

namespace App\Http\Controllers;

use App\Models\EmpOfficial;
use App\Models\EmpPersonal;
use App\Models\LeaveEntryMaster;
use App\Models\LeaveEntryDetails;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Http\Request;

class EmpControllers extends BaseController
{
    // ─────────────────────────────────────────────────────
    //  NETWORK DRIVE BASE PATHS
    //  Y: = \\192.168.210.205\emp_photo  → employee photos
    //  Z: = \\192.168.210.205\emp_sign   → employee signatures
    //  HTTP server serving both drives at 192.168.189.205:81
    // ─────────────────────────────────────────────────────
    const NET_PHOTO   = '\\\\192.168.18.205\\emp_photo\\'; // Y: drive
    const NET_SIGN    = '\\\\192.168.18.205\\emp_sign\\';  // Z: drive
    const HTTP_PHOTO  = 'http://192.168.189.18:81/emp_photo/';
    const HTTP_SIGN   = 'http://192.168.189.18:81/emp_sign/';

    // ── Tab 1 data only (2 queries) ───────────────────────
    private function tab1Data(): array {
        return [
            'companyList' => DB::table('COMPANY_PROFILE')->get(),
            'religion'    => DB::table('RELIGION')->get(),
        ];
    }

    // ─────────────────────────────────────────────────────
    //  LIST
    // ─────────────────────────────────────────────────────
    public function empList() {
        if (!session('LoggedUser')) return redirect('login');
        $empList = DB::table('EMP_PERSONAL')
            ->select('NEW_EMPNO', 'EMPNO',
                DB::raw("TRIM(FIRST_NAME)||' '||TRIM(NVL(MIDDLE_NAME,''))||' '||TRIM(NVL(LAST_NAME,'')) AS EMPNAME"),
                'FATHER_NAME', 'MOTHER_NAME', 'SEX', 'STATUS')
            ->where('STATUS', '!=', 'Inactive')
            ->orderBy('NEW_EMPNO', 'ASC')->get();
        return view('hrm.emplist', compact('empList'));
    }

    // ─────────────────────────────────────────────────────
    //  CREATE FORM  (Tab 1 only, fast)
    // ─────────────────────────────────────────────────────
    public function empentry() {
        if (!session('LoggedUser')) return redirect('login');
        return view('hrm.empform', $this->tab1Data());
    }

    // ─────────────────────────────────────────────────────
    //  EDIT FORM  (Tab 1 + emp record only, fast)
    // ─────────────────────────────────────────────────────
    public function empEdit($empno) {
        if (!session('LoggedUser')) return redirect('login');
        $emp = EmpPersonal::where('empno', $empno)->first();
        if (!$emp) return redirect()->route('emplist')->with('fail', 'Employee not found.');
    
        return view('hrm.empform', array_merge(['emp' => $emp], $this->tab1Data()));
    }

    // ─────────────────────────────────────────────────────
    //  AJAX TAB: OFFICIAL  (loads dropdown + emp data)
    // ─────────────────────────────────────────────────────
    public function tabOfficial($empno) {
        if (!session('LoggedUser')) abort(401);
        $emp = EmpPersonal::where('empno', $empno)->with('getempofficial')->first();
        return view('hrm.tabs.tab_official', [
            'emp'         => $emp,
            'empno'       => $empno,
            'companyList' => DB::table('COMPANY_PROFILE')->select('COMPANY_ID', 'COMPANY_NAME')->orderBy('COMPANY_ID', 'desc')->get(),
            'empType'     => DB::table('HRM.EMP_TYPE')->select('EMP_TYPE', 'TYPE_SET', 'PRIORITY')->get(),
        ]);
    }

    // ─────────────────────────────────────────────────────
    //  AJAX TAB: LOCATION  (no dropdowns — all LOV)
    // ─────────────────────────────────────────────────────
    public function tabLocation($empno) {
        if (!session('LoggedUser')) abort(401);
        $emp = EmpPersonal::where('empno', $empno)->with('getemploc')->first();
        return view('hrm.tabs.tab_location', ['emp' => $emp, 'empno' => $empno]);
    }

    // ─────────────────────────────────────────────────────
    //  AJAX TABS: simple partials (no DB queries needed)
    // ─────────────────────────────────────────────────────
    public function tabEducation($empno)   { if (!session('LoggedUser')) abort(401); return view('hrm.tabs.tab_education',   ['empno' => $empno]); }
    public function tabShortCourse($empno) { if (!session('LoggedUser')) abort(401); return view('hrm.tabs.tab_shortcourse', ['empno' => $empno]); }
    public function tabTraining($empno)    { if (!session('LoggedUser')) abort(401); return view('hrm.tabs.tab_training',    ['empno' => $empno]); }
    public function tabExperience($empno)  { if (!session('LoggedUser')) abort(401); return view('hrm.tabs.tab_experience',  ['empno' => $empno]); }
    public function tabNominee($empno)     { if (!session('LoggedUser')) abort(401); return view('hrm.tabs.tab_nominee',     ['empno' => $empno]); }
    public function tabJobHistory($empno)  { if (!session('LoggedUser')) abort(401); return view('hrm.tabs.tab_jobhistory',  ['empno' => $empno]); }

    // ─────────────────────────────────────────────────────
    //  DELETE EMPLOYEE
    // ─────────────────────────────────────────────────────
    public function deleteEmployee($empno) {
        if (!session('LoggedUser')) return response()->json(['message' => 'Unauthorized'], 401);
        if (!DB::table('EMP_PERSONAL')->where('EMPNO', $empno)->exists())
            return response()->json(['message' => 'Employee not found.'], 404);
        try {
            DB::transaction(function () use ($empno) {
                foreach (['EMP_WORK_EXP', 'EMP_TRAINING', 'EMP_SHORT_COURSE', 'EMP_QUALIFICATION',
                          'EMP_FAMILY', 'EMP_JOB_HISTORY', 'EMP_LOCATION', 'EMP_OFFICIAL', 'EMP_PERSONAL'] as $t)
                    DB::table($t)->where('EMPNO', $empno)->delete();
            });
            return response()->json(['success' => true, 'message' => "Employee {$empno} deleted."]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ─────────────────────────────────────────────────────
    //  Helper: parse dd-mm-yyyy → Y-m-d for DB storage
    //  Returns null if blank.
    // ─────────────────────────────────────────────────────
    private function parseDate(?string $val): ?string
    {
        if (!$val || trim($val) === '') return null;
        $val = str_replace('/', '-', trim($val));
        try {
            return \Carbon\Carbon::createFromFormat('d-m-Y', $val)->format('Y-m-d');
        } catch (\Exception $e) {
            try {
                return \Carbon\Carbon::parse($val)->format('Y-m-d');
            } catch (\Exception $e2) {
                return null;
            }
        }
    }

    // ─────────────────────────────────────────────────────
    //  Helper: save uploaded image to network drive
    //  $field : 'photo'  → Y: drive (\\192.168.210.205\emp_photo)
    //           'signature' → Z: drive (\\192.168.210.205\emp_sign)
    //  $empno : used as filename base e.g. EMP001.jpg
    //  Returns: filename only e.g. "EMP001.jpg"  or null on failure
    // ─────────────────────────────────────────────────────
    private function saveImage(Request $request, string $field, string $empno): ?string
    {
        if (!$request->hasFile($field)) return null;
        $file = $request->file($field);
        if (!$file->isValid()) return null;

        // Y: = photo,  Z: = signature
        $networkPath = ($field === 'photo') ? self::NET_PHOTO : self::NET_SIGN;

        $ext      = strtolower($file->getClientOriginalExtension() ?: 'jpg');
        $filename = strtoupper($empno) . '.' . $ext;

        // Ensure network directory is accessible
        if (!file_exists($networkPath)) {
            mkdir($networkPath, 0775, true);
        }

        // Move file directly to network drive
        $file->move($networkPath, $filename);

        // Store only the filename in the DB (Y or Z column)
        return $filename; // e.g. EMP001.jpg
    }

    // ─────────────────────────────────────────────────────
    //  Helper: build public HTTP URL from stored filename
    //  $type    : 'photo' or 'sign'
    //  $filename: value stored in Y or Z column e.g. EMP001.jpg
    // ─────────────────────────────────────────────────────
    private function imageUrl(string $type, ?string $filename): ?string
    {
        if (!$filename) return null;
        $base = ($type === 'photo') ? self::HTTP_PHOTO : self::HTTP_SIGN;
        return $base . $filename;
    }

    // ─────────────────────────────────────────────────────
    //  SAVE / UPDATE PERSONAL  (with photo Y: + signature Z:)
    // ─────────────────────────────────────────────────────
    public function saveEmpPersonal(Request $request)
    {
        $empno  = trim($request->input('empno'));
        $record = EmpPersonal::where('empno', $empno)->first();

        $validator = Validator::make($request->all(), [
            'empno'         => 'required|string',
            'first_name'    => 'nullable|string|max:100',
            'last_name'     => 'nullable|string|max:100',
            'company_id'    => 'nullable|integer',
            'emp_mobile_no' => 'nullable|string|max:20',
            'photo'         => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'signature'     => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $data = array_merge($request->only([
                'empno', 'first_name', 'middle_name', 'last_name', 'b_name', 'father_name',
                'mother_name', 'husband_name', 'gurdian_name', 'sex', 'marial_status',
                'religion_id', 'blood_group', 'national_id_no', 'id_mark', 'company_id',
                'passport_no', 'place_of_issue', 'birthday_id',
                'emp_mobile_no', 'sms_mobile_no', 'office_food', 'status', 'hbs_test',
                'nationality_desc', 'last_education',
            ]), [
                'dob'           => $this->parseDate($request->input('dob')),
                'as_on'         => $this->parseDate($request->input('as_on')),
                'id_card_issue' => $this->parseDate($request->input('id_card_issue')),
                'valid_till'    => $this->parseDate($request->input('valid_till')),
                'update_by'     => auth()->id() ?? 1,
                'update_date'   => now(),
            ]);

            // ── Photo → Y column (network drive Y:) ──
           // PHOTO
$photoFile = $this->saveImage($request, 'photo', $empno);
if ($photoFile) {
    $data['emp_img'] = $photoFile;   // store filename with extension
}

// SIGNATURE
$signFile = $this->saveImage($request, 'signature', $empno);
if ($signFile) {
    $data['emp_sign'] = $signFile;   // store filename with extension
}

            // ── Build HTTP URLs for front-end preview update ──
            $photoUrl = $this->imageUrl('photo', $photoFile ?? ($record->Y ?? null));
            $signUrl  = $this->imageUrl('sign',  $signFile  ?? ($record->Z  ?? null));

            if ($record) {
                $record->update($data);
                return response()->json([
                    'success'   => true,
                    'message'   => 'Personal info updated successfully.',
                    'photo_url' => $photoFile ? $this->imageUrl('photo', $photoFile) : null,
                    'sign_url'  => $signFile  ? $this->imageUrl('sign',  $signFile)  : null,
                ], 200);
            }

            $data['insert_by']   = auth()->id() ?? 1;
            $data['insert_date'] = now();
            EmpPersonal::create($data);

            return response()->json([
                'success'   => true,
                'message'   => 'Personal info saved successfully.',
                'photo_url' => $photoFile ? $this->imageUrl('photo', $photoFile) : null,
                'sign_url'  => $signFile  ? $this->imageUrl('sign',  $signFile)  : null,
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ═════════════════════════════════════════════════════════════════════
    //  SAVE OFFICIAL
    // ═════════════════════════════════════════════════════════════════════
    public function saveEmpOfficial(Request $request)
    {
        try {
            $empno = trim($request->input('empno'));

            if (!$empno) {
                return response()->json(['success' => false, 'message' => 'Employee number is required'], 400);
            }

            $record = EmpOfficial::where('empno', $empno)->first();

            $data = [
                'empno'                 => $empno,
                'company_id'            => $request->input('company_id'),
                'emp_type'              => $request->input('emp_type'),
                'dept_no'               => $request->input('dept_no'),
                'dept_name'             => $request->input('dept_no_name'),
                'section_no'            => $request->input('section_no'),
                'section_name'          => $request->input('section_no_name'),
                'floor_id'              => $request->input('floor_id'),
                'floor_desc'            => $request->input('floor_id_name'),
                'line'                  => $request->input('line'),
                'line_info'             => $request->input('line_name'),
                'des_id'                => $request->input('des_id'),
                'des_name'              => $request->input('des_id_name'),
                'grade_id'              => $request->input('grade_id'),
                'grade_name'            => $request->input('grade_id_name'),
                'shift_code'            => $request->input('shift_code'),
                'shift_name'            => $request->input('shift_code_name'),
                'cal_code'              => $request->input('cal_code'),
                'weekly_off'            => $request->input('weekly_off'),
                's_group_name'          => $request->input('s_group_name'),
                'joining_date'          => $this->parseDate($request->input('joining_date') ?: $request->input('join_date')),
                'join_time'             => $request->input('join_time'),
                'conform_date'          => $this->parseDate($request->input('conform_date') ?: $request->input('confirmation_date')),
                'confirmation_duration' => $request->input('confirmation_duration'),
                'last_promo_date'       => $this->parseDate($request->input('last_promo_date')),
                'last_increment_date'   => $this->parseDate($request->input('last_increment_date')),
                'increment_date'        => $this->parseDate($request->input('increment_date')),
                'as_on_join'            => $this->parseDate($request->input('as_on_join')),
                'provision_period'      => $request->input('provision_period'),
                'opt_no'                => $request->input('opt_no'),
                'punch_card_no'         => $request->input('punch_card_no'),
                'proximity_card_no'     => $request->input('proximity_card_no'),
                'ot_cat'                => $request->input('ot_cat'),
                'attn_eff_date'         => $this->parseDate($request->input('attn_eff_date')),
                'lv_cat_id'             => $request->input('lv_cat_id'),
                'lv_cat_name'           => $request->input('lv_cat_id_name'),
                'entry_date'            => $this->parseDate($request->input('entry_date')),
                'gross'                 => $request->input('gross'),
                'other_allowance'       => $request->input('other_allowance'),
                'bank_name'             => $request->input('bank_name'),
                'bank_ac_no'            => $request->input('bank_ac_no'),
                'tin_no'                => $request->input('tin_no'),
                'tax_deduction'         => $request->input('tax_deduction'),
                'service_book_number'   => $request->input('service_book_number'),
                'ac_no'                 => $request->input('ac_no'),
                'termination_date'      => $this->parseDate($request->input('termination_date')),
                'resigned_date'         => $this->parseDate($request->input('resigned_date')),
                'reason'                => $request->input('reason'),
                'is_lefty'              => $request->input('is_lefty'),
                'update_by'             => auth()->id() ?? 1,
                'update_date'           => now(),
            ];

            // Remove null/empty values to avoid overwriting existing data
            $data = array_filter($data, fn($v) => $v !== null && $v !== '');

            if ($record) {
                $record->update($data);
                \Log::info('Official Info Updated', ['empno' => $empno]);
                return response()->json([
                    'success' => true,
                    'message' => 'Official information updated successfully',
                    'data'    => ['empno' => $empno, 'dept_name' => $data['dept_name'] ?? null, 'des_name' => $data['des_name'] ?? null]
                ], 200);
            }

            $data['insert_by']   = auth()->id() ?? 1;
            $data['insert_date'] = now();
            EmpOfficial::create($data);
            \Log::info('Official Info Created', ['empno' => $empno]);

            return response()->json([
                'success' => true,
                'message' => 'Official information saved successfully',
                'data'    => ['empno' => $empno, 'dept_name' => $data['dept_name'] ?? null, 'des_name' => $data['des_name'] ?? null]
            ], 201);

        } catch (\Illuminate\Database\QueryException $e) {
            \Log::error('DB Error saveEmpOfficial', ['empno' => $request->input('empno'), 'error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            \Log::error('Error saveEmpOfficial', ['empno' => $request->input('empno'), 'error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    // ═════════════════════════════════════════════════════════════════════
    //  GET OFFICIAL DATA
    // ═════════════════════════════════════════════════════════════════════
    public function getEmpOfficial($empno)
    {
        if (!session('LoggedUser')) return response()->json(['message' => 'Unauthorized'], 401);
        try {
            $official = EmpOfficial::where('empno', $empno)->first();
            if (!$official) return response()->json(['success' => false, 'message' => 'Official record not found'], 404);
            return response()->json(['success' => true, 'data' => $official]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ─────────────────────────────────────────────────────
    //  AUTOCOMPLETE / SEARCH
    // ─────────────────────────────────────────────────────
    public function empsearch(Request $request)
    {
        $rows = DB::table('EMP_PERSONAL')
            ->select('NEW_EMPNO')
            ->where('NEW_EMPNO', 'like', '%' . $request->search_key . '%')
            ->take(20)->get();
        return response()->json(['data' => $rows]);
    }

    public function getEmpDetSearch(Request $request)
    {
        return EmpPersonal::where('new_empno', '=', $request->empno)
            ->with('getempofficial', 'getemploc', 'empQualification',
                   'getEmpShortModel', 'getEmpFamily', 'getEmpHistory',
                   'getEmpTraining', 'getEmpWorkExp')
            ->get();
    }

    public function empSearchExist(Request $request)
    {
        return DB::table('EMP_PERSONAL')
            ->select(DB::raw('COUNT(EMPNO) as EMPCOUNT'))
            ->where('EMPNO', '=', $request->input('empno'))->get();
    }

    // ─────────────────────────────────────────────────────
    //  LEAVE
    // ─────────────────────────────────────────────────────
    public function getLeaveDetails($empno, $year)
    {
        $rows = DB::table('LEAVE_ENTRY_DETAILS')->where('YEAR', '=', $year)->where('EMPNO', '=', $empno)->get();
        return view('hrm.leave_table', ['getLeaveDetails' => $rows]);
    }

    public function getLeavePrebal($empno, $year, $lv)
    {
        return DB::table(DB::raw('LEAVE_ENTRY_DETAILS LV'))
            ->select(DB::raw('NVL(SUM(APPROVE_DAYS),0) APPROVE_DAYS'))
            ->where('LV.leave_id', '=', $lv)->where('empno', '=', $empno)
            ->whereRaw('\'' . $year . '\' = to_char(lv_to,\'YYYY\')')
            ->whereRaw('\'' . $year . '\' = to_char(lv_from,\'YYYY\')')->get();
    }

    public function getLeavBal($lv)
    {
        return DB::table('leave_info')->select(DB::raw('nvl(max_days,60)max_days'))->where('leave_id', '=', $lv)->get();
    }

    public function leaveEntryIns(Request $request)
    {
        $d = $request->input();
        $c = DB::table('LEAVE_ENTRY_MASTER')->selectRaw('COUNT(*) AS COUNT_LEAVE')
            ->where('YEAR', '=', $d['year'])->where('EMPNO', '=', $d['empno'])
            ->where('COMPANY_ID', '=', $d['company_id'])->first();
        if (optional($c)->count_leave > 0) return response()->json(['status' => 200]);
        try {
            $l = new LeaveEntryMaster;
            $l->company_id = $d['company_id'];
            $l->empno      = $d['empno'];
            $l->lv_cat_id  = $d['lv_cat_id'];
            $l->new_empno  = $d['empno'];
            $l->year       = $d['year'];
            $l->save();
            return response()->json(['status' => 200]);
        } catch (\Exception $e) { return $e; }
    }

    public function leaveEntryDet(Request $request)
    {
        $d   = $request->input();
        $max = DB::table('LEAVE_ENTRY_details')
            ->select(DB::raw('(nVL(MAX(LV_SL),0)+1) lv_sl'))
            ->where('YEAR', '=', $d['year_det'])->where('EMPNO', '=', $d['emp_no_det'])
            ->where('lv_cat_id', '=', $d['lv_cat_id_det'])->first();
        try {
            $l = new LeaveEntryDetails;
            $l->lv_cat_id       = $d['lv_cat_id_det'];
            $l->year            = $d['year_det'];
            $l->empno           = $d['emp_no_det'];
            $l->balance         = $d['new_balance'];
            $l->application_date= $d['submitted'];
            $l->approve_date    = $d['approve_date'];
            $l->approve_days    = $d['approve_days'];
            $l->approve_by      = $d['approve_by'];
            $l->lv_from         = $d['lv_from'];
            $l->lv_to           = $d['lv_to'];
            $l->leave_id        = $d['leave_name'];
            $l->max_days        = $d['max_days'];
            $l->pre_balance     = $d['pre_balance'];
            $l->remax           = $d['remarks'];
            $l->information     = $d['information'];
            $l->lv_sl           = $max->lv_sl;
            $l->save();
            return response()->json(['status' => 200]);
        } catch (\Exception $e) { return $e; }
    }

    public function deleteLeave($empno, $year, $sl)
    {
        $r = DB::table('LEAVE_ENTRY_details')->select('lv_sl')
            ->where('YEAR', '=', $year)->where('EMPNO', '=', $empno)->where('lv_sl', '=', $sl)->first();
        if (!optional($r)->lv_sl == null) {
            try {
                DB::table('LEAVE_ENTRY_details')
                    ->where('YEAR', '=', $year)->where('EMPNO', '=', $empno)->where('lv_sl', '=', $sl)->delete();
                return response()->json(['status2' => 200]);
            } catch (\Exception $e) { return response()->json([$e->getCode()]); }
        }
    }

    public function logout()
    {
        session()->pull('LoggedUser');
        return redirect('login');
    }
}