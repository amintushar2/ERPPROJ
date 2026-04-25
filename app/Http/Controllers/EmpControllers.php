<?php

namespace App\Http\Controllers;

use App\Models\EmpOfficial;
use App\Models\EmpPersonal;
use App\Models\LeaveEntryMaster;
use App\Models\LeaveEntryDetails;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class EmpControllers extends BaseController

{




    const NET_PHOTO   = '\\\\192.168.210.205\\emp_photo\\'; // Y: drive
    const NET_SIGN    = '\\\\192.168.210.205\\emp_sign\\';  // Z: drive
    const HTTP_PHOTO  = 'http://192.168.210.18:81/';
    const HTTP_SIGN   = 'http://192.168.210.18:82/';

 //ll

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
        $companyList = DB::table('COMPANY_PROFILE')
            ->select('COMPANY_ID', 'COMPANY_NAME')
            ->orderBy('COMPANY_NAME', 'ASC')
            ->get();
        return view('hrm.emplist', compact('companyList'));
    }

    // ─────────────────────────────────────────────────────
    //  EMPLOYEE LIST SEARCH  (AJAX)
    //  GET /hrm/emplist/search
    //  Default status=Active → first load shows active only
    //  status='' → all employees
    // ─────────────────────────────────────────────────────
    public function empListSearch(Request $request) {
        if (!session('LoggedUser')) return response()->json(['message' => 'Unauthorized'], 401);
        $q = DB::table('EMP_PERSONAL AS EP')
            ->leftJoin('EMP_OFFICIAL AS EO', 'EO.EMPNO', '=', 'EP.EMPNO')
            ->select(
                'EP.EMPNO', 'EP.NEW_EMPNO',
                DB::raw("TRIM(EP.FIRST_NAME)||' '||TRIM(NVL(EP.MIDDLE_NAME,''))||' '||TRIM(NVL(EP.LAST_NAME,'')) AS EMPNAME"),
                'EP.FATHER_NAME', 'EP.MOTHER_NAME', 'EP.EMP_MOBILE_NO',
                'EP.SEX', 'EP.STATUS', 'EO.COMPANY_ID'
            );

        // Status — empty = All, 'Active' = default first load
        $status = $request->input('status', 'Active');
$q->when(!empty($status), function ($query) use ($status) {
    $query->where('EP.STATUS', $status);
});
        // Keyword: name / father / mother
        if ($search = trim($request->input('search', ''))) {
            $like = '%' . strtoupper($search) . '%';
            $q->where(function($s) use ($like) {
                $s->whereRaw("UPPER(TRIM(EP.FIRST_NAME)||' '||TRIM(NVL(EP.MIDDLE_NAME,''))||' '||TRIM(NVL(EP.LAST_NAME,''))) LIKE ?", [$like])
                  ->orWhereRaw('UPPER(EP.FATHER_NAME) LIKE ?', [$like])
                  ->orWhereRaw('UPPER(EP.MOTHER_NAME) LIKE ?', [$like]);
            });
        }

        // Emp No (EMPNO or NEW_EMPNO)
        if ($empno = trim($request->input('empno', ''))) {
            $q->where(function($s) use ($empno) {
                $s->whereRaw('UPPER(EP.EMPNO) LIKE ?',      ['%'.strtoupper($empno).'%'])
                  ->orWhereRaw('UPPER(EP.NEW_EMPNO) LIKE ?',['%'.strtoupper($empno).'%']);
            });
        }

        // Mobile
        if ($mobile = trim($request->input('mobile', '')))
            $q->where('EP.EMP_MOBILE_NO', 'like', '%'.$mobile.'%');

        // Company
        if ($co = $request->input('company_id', ''))
            $q->where('EO.COMPANY_ID', $co);

        $data = $q->orderBy('EP.NEW_EMPNO', 'ASC')->get();
        return response()->json(['data' => $data, 'total' => $data->count()]);
    }

    // ─────────────────────────────────────────────────────
    //  CREATE FORM  (Tab 1 only, fast)
    // ─────────────────────────────────────────────────────
    public function empentry() {
        if(!session('LoggedUser')) return redirect('login');
        return view('hrm.empform', $this->tab1Data());
    }

    // ─────────────────────────────────────────────────────
    //  EDIT FORM  (Tab 1 + emp record only, fast)
    // ─────────────────────────────────────────────────────
    public function empEdit($empno) {
        if(!session('LoggedUser')) return redirect('login');
        $emp = EmpPersonal::where('empno',$empno)->first();
        if(!$emp) return redirect()->route('emplist')->with('fail','Employee not found.');
        return view('hrm.empform', array_merge(['emp'=>$emp], $this->tab1Data()));
    }
public function empEditEntry($empno) {
        if(!session('LoggedUser')) return redirect('login');
        $emp = EmpPersonal::where('new_empno',$empno)->first();
        if(!$emp) return redirect()->route('empnewentry')->with('fail','Employee not found.');
        return view('hrm.empform', array_merge(['emp'=>$emp], $this->tab1Data()));
    }
    // ─────────────────────────────────────────────────────
    //  AJAX TAB: OFFICIAL  (loads dropdown + emp data)
    // ─────────────────────────────────────────────────────
    public function tabOfficial($empno) {
        if(!session('LoggedUser')) abort(401);
        $emp = EmpPersonal::where('empno',$empno)->with('getempofficial')->first();
        return view('hrm.tabs.tab_official', [
            'emp'         => $emp,
            'empno'       => $empno,
            // Only these two are server-rendered in official tab
            'companyList' => DB::table('COMPANY_PROFILE')->select('COMPANY_ID','COMPANY_NAME')->orderBy('COMPANY_ID','desc')->get(),
            'empType'     => DB::table('HRM.EMP_TYPE')->select('EMP_TYPE','TYPE_SET','PRIORITY')->get(),
        ]);
    }

    // ─────────────────────────────────────────────────────
    //  AJAX TAB: LOCATION  (no dropdowns — all LOV)
    // ─────────────────────────────────────────────────────
    public function tabLocation($empno) {
        if(!session('LoggedUser')) abort(401);
        $emp = EmpPersonal::where('empno',$empno)->with('getemploc')->first();
        return view('hrm.tabs.tab_location', ['emp'=>$emp,'empno'=>$empno]);
    }

    // ─────────────────────────────────────────────────────
    //  AJAX TABS: simple partials (no DB queries needed)
    // ─────────────────────────────────────────────────────
    public function tabEducation($empno)  { if(!session('LoggedUser')) abort(401); return view('hrm.tabs.tab_education',  ['empno'=>$empno]); }
    public function tabShortCourse($empno){ if(!session('LoggedUser')) abort(401); return view('hrm.tabs.tab_shortcourse',['empno'=>$empno]); }
    public function tabTraining($empno)   { if(!session('LoggedUser')) abort(401); return view('hrm.tabs.tab_training',   ['empno'=>$empno]); }
    public function tabExperience($empno) { if(!session('LoggedUser')) abort(401); return view('hrm.tabs.tab_experience', ['empno'=>$empno]); }
    public function tabNominee($empno)    { if(!session('LoggedUser')) abort(401); return view('hrm.tabs.tab_nominee',    ['empno'=>$empno]); }
    public function tabJobHistory($empno) { if(!session('LoggedUser')) abort(401); return view('hrm.tabs.tab_jobhistory', ['empno'=>$empno]); }

    // ─────────────────────────────────────────────────────
    //  DELETE EMPLOYEE
    // ─────────────────────────────────────────────────────
    public function deleteEmployee($empno) {
        if(!session('LoggedUser')) return response()->json(['message'=>'Unauthorized'],401);
        if(!DB::table('EMP_PERSONAL')->where('EMPNO',$empno)->exists())
            return response()->json(['message'=>'Employee not found.'],404);
        try {
            DB::transaction(function() use ($empno) {
                foreach(['EMP_WORK_EXP','EMP_TRAINING','EMP_SHORT_COURSE','EMP_QUALIFICATION',
                         'EMP_FAMILY','EMP_JOB_HISTORY','EMP_LOCATION','EMP_OFFICIAL','EMP_PERSONAL'] as $t)
                    DB::table($t)->where('EMPNO',$empno)->delete();
            });
            return response()->json(['success'=>true,'message'=>"Employee {$empno} deleted."]);
        } catch(\Exception $e) {
            return response()->json(['success'=>false,'message'=>$e->getMessage()],500);
        }
    }

    // ─────────────────────────────────────────────────────
    //  SAVE PERSONAL
    // ─────────────────────────────────────────────────────
public function saveEmpPersonal(Request $request)
{
    $empno  = trim($request->input('empno'));
    $record = EmpPersonal::where('empno', $empno)->first();

    $validator = Validator::make($request->all(), [
        'empno'         => 'required|string',
        'first_name'    => 'required|string|max:100',
        'last_name'     => 'required|string|max:100',
        'company_id'    => 'required|integer',
        'emp_mobile_no' => 'nullable|string|max:20',
        'photo'         => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        'signature'     => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
    }

    try {
        $parseDate = fn($val) => !empty($val) ? Carbon::parse($val)->format('Y-m-d') : null;

        $data = array_merge($request->only([
            'empno', 'first_name', 'middle_name', 'last_name', 'b_name', 'father_name',
            'mother_name', 'husband_name', 'gurdian_name', 'sex', 'marial_status',
            'religion_id', 'blood_group', 'national_id_no', 'id_mark', 'company_id',
            'passport_no', 'place_of_issue', 'birthday_id',
            'emp_mobile_no', 'sms_mobile_no', 'office_food', 'status', 'hbs_test',
            'nationality_desc', 'last_education',
        ]), [
            'dob'           => $parseDate($request->input('dob')),
            'as_on'         => $parseDate($request->input('as_on')),
            'id_card_issue' => $parseDate($request->input('id_card_issue')),
            'valid_till'    => $parseDate($request->input('valid_till')),
            'update_by'     => auth()->id() ?? 1,
            'update_date'   => now(),
        ]);

        // ── Images: only update column if a new file was uploaded ──
        // ── otherwise keep whatever is already stored             ──
        $photoFile = $this->saveImage($request, 'photo', $empno);
        $signFile  = $this->saveImage($request, 'signature', $empno);

        if ($photoFile) {
            // New file uploaded → update column
            $data['emp_img'] = $photoFile;
        } elseif ($record) {
            // No new file → preserve existing value from DB
            $data['emp_img'] = $record->emp_img;
        }
        // If it's a brand-new record and no file uploaded → leave emp_img out of $data (stays null)

        if ($signFile) {
            $data['emp_sign'] = $signFile;
        } elseif ($record) {
            $data['emp_sign'] = $record->emp_sign;
        }

        // ── Build preview URLs (use new file first, fall back to DB value) ──
        $photoUrl = $this->imageUrl('photo', $photoFile ?? ($record->emp_img ?? null));
        $signUrl  = $this->imageUrl('sign',  $signFile  ?? ($record->emp_sign ?? null));

        // ── Update or Insert ──
        if ($record) {
            $record->update($data);
            return response()->json([
                'success'   => true,
                'message'   => 'Personal info updated successfully.',
                'photo_url' => $photoUrl,
                'sign_url'  => $signUrl,
            ], 200);
        }

        $data['insert_by']   = auth()->id() ?? 1;
        $data['insert_date'] = now();
        EmpPersonal::create($data);

        return response()->json([
            'success'   => true,
            'message'   => 'Personal info saved successfully.',
            'photo_url' => $photoUrl,
            'sign_url'  => $signUrl,
        ], 201);

    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}


private function saveImage(Request $request, string $field, string $empno): ?string
{
    if (!$request->hasFile($field)) return null;

    $file = $request->file($field);
    if (!$file->isValid()) return null;

    $ext      = strtolower($file->getClientOriginalExtension()) ?: 'jpg';
    $filename = strtoupper($empno) . '.' . $ext;
    $folder   = ($field === 'photo') ? 'emp_photo' : 'emp_sign';
    $path     = $folder . '/' . $filename;

    $disk = Storage::disk('ftp');

    // ── Delete old file if it exists (handles extension mismatch e.g. old=.png new=.jpg) ──
    foreach (['jpg', 'jpeg', 'png', 'gif'] as $oldExt) {
        $oldPath = $folder . '/' . strtoupper($empno) . '.' . $oldExt;
        if ($oldPath !== $path && $disk->exists($oldPath)) {
            $disk->delete($oldPath);
        }
    }

    // ── Upload new file ──
    $stream = fopen($file->getRealPath(), 'rb');
    try {
        $disk->put($path, $stream);
    } finally {
        if (is_resource($stream)) {
            fclose($stream);
        }
    }

    return $filename;
}


//     public function saveEmpPersonal(Request $request) {
//         $empno  = trim($request->input('empno'));
//         $record = EmpPersonal::where('empno', $empno)->first();
// //dd(Carbon::parse($request->input('dob'))->format('Y-m-d'));
// //dd($request->input('dob'));
//         $validator = Validator::make($request->all(), [
//             'empno'         => 'required|string',
//             'first_name'    => 'required|string|max:100',
//             'last_name'     => 'required|string|max:100',
//             'company_id'    => 'required|integer',
//             'emp_mobile_no' => 'nullable|string|max:20',
//             'photo'         => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
//             'signature'     => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
//         ]);

//         if ($validator->fails()) {
//             return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
//         }

//         try {
//             $data = array_merge($request->only([
//                 'empno', 'first_name', 'middle_name', 'last_name', 'b_name', 'father_name',
//                 'mother_name', 'husband_name', 'gurdian_name', 'sex', 'marial_status',
//                 'religion_id', 'blood_group', 'national_id_no', 'id_mark', 'company_id',
//                 'passport_no', 'place_of_issue', 'birthday_id',
//                 'emp_mobile_no', 'sms_mobile_no', 'office_food', 'status', 'hbs_test',
//                 'nationality_desc', 'last_education',
//             ]), [
//                 'dob'           => Carbon::parse($request->input('dob'))->format('Y-m-d'),
//                 'as_on'         =>Carbon::parse($request->input('as_on'))->format('Y-m-d'),
//                 'id_card_issue' => Carbon::parse($request->input('id_card_issue'))->format('Y-m-d'),
//                 'valid_till'    => Carbon::parse($request->input('valid_till'))->format('Y-m-d'),
//                 'update_by'     => auth()->id() ?? 1,
//                 'update_date'   => now(),
//             ]);

//             // ── Photo → Y column (network drive Y:) ──
//            // PHOTO
// $photoFile = $this->saveImage($request, 'photo', $empno);
// if ($photoFile) {
//     $data['emp_img'] = $photoFile;   // store filename with extension
// }

// // SIGNATURE
// $signFile = $this->saveImage($request, 'signature', $empno);
// if ($signFile) {
//     $data['emp_sign'] = $signFile;   // store filename with extension
// }

//             // ── Build HTTP URLs for front-end preview update ──
//             // $photoUrl = $this->imageUrl('photo', $photoFile ?? ($record->Y ?? null));
//             // $signUrl  = $this->imageUrl('sign',  $signFile  ?? ($record->Z  ?? null));

// $photoUrl = null;
// $signUrl  = null;

// if ($photoFile) {
//     $photoUrl = $this->imageUrl('photo', $photoFile);
// } elseif ($record && !empty($record->emp_img)) {
//     $photoUrl = $this->imageUrl('photo', $record->emp_img);
// }

// if ($signFile) {
//     $signUrl = $this->imageUrl('sign', $signFile);
// } elseif ($record && !empty($record->emp_sign)) {
//     $signUrl = $this->imageUrl('sign', $record->emp_sign);
// }
//             if ($record) {
//                 $record->update($data);
//                 return response()->json([
//                     'success'   => true,
//                     'message'   => 'Personal info updated successfully.',
// 'photo_url' => $photoUrl,
// 'sign_url'  => $signUrl,                ], 200);
//             }

//             $data['insert_by']   = auth()->id() ?? 1;
//             $data['insert_date'] = now();
//             EmpPersonal::create($data);

//             return response()->json([
//                 'success'   => true,
//                 'message'   => 'Personal info saved successfully.',
//                 'photo_url' => $photoFile ? $this->imageUrl('photo', $photoFile) : null,
//                 'sign_url'  => $signFile  ? $this->imageUrl('sign',  $signFile)  : null,
//             ], 201);

//         } catch (\Exception $e) {
//             return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
//         }
//     }
       // ─────────────────────────────────────────────────────
    //  Helper: save uploaded image to network drive
    //  $field : 'photo'  → Y: drive (\\192.168.210.205\emp_photo)
    //           'signature' → Z: drive (\\192.168.210.205\emp_sign)
    //  $empno : used as filename base e.g. EMP001.jpg
    //  Returns: filename only e.g. "EMP001.jpg"  or null on failure
    // ─────────────────────────────────────────────────────
//    private function saveImage(Request $request, string $field, string $empno): ?string
// {
//     if (!$request->hasFile($field)) return null;

//     $file = $request->file($field);
//     if (!$file->isValid()) return null;

//     $ext      = strtolower($file->getClientOriginalExtension() ?: 'jpg');
//     $filename = strtoupper($empno) . '.' . $ext;

//     // Folder name on FTP
//     $folder = ($field === 'photo') ? 'emp_photo' : 'emp_sign';

//     // Full path on FTP
//     $path = $folder . '/' . $filename;

//     // Upload file via FTP
//     Storage::disk('ftp')->put($path, fopen($file->getRealPath(), 'r+'));

//     return $filename;
// }


private function imageUrl(string $type, ?string $filename): ?string
{
    if (empty($filename)) return null;

    $folder  = ($type === 'photo') ? 'emp_photo' : 'emp_sign';
    $baseUrl = env('FTP_URL', 'http://fallback-url.com/files');
//dd($baseUrl);
    return rtrim($baseUrl, '/') . '/' . $folder . '/' . $filename;
}
    // ═════════════════════════════════════════════════════════════════════
    //  SAVE OFFICIAL (Enhanced with LOV Value + Text Support)
    // ═════════════════════════════════════════════════════════════════════
    public function saveEmpOfficial(Request $request) {
        try {
            $empno  = trim($request->input('empno'));
            
            if (!$empno) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Employee number is required'
                ], 400);
            }
            
            $record = EmpOfficial::where('empno', $empno)->first();
            
            // ─────────────────────────────────────────────────────────
            //  Build data array with both IDs and Names from LOV
            // ─────────────────────────────────────────────────────────
            $data = [
                // ─── Base Information ─────────────────────────────────
                'empno'           => $empno,
                'company_id'      => $request->input('company_id'),
                'emp_type'        => $request->input('emp_type'),
                
                // ─── Department (LOV) ─────────────────────────────────
                'dept_no'         => $request->input('dept_no'),
                'dept_name'       => $request->input('dept_no_name'), // From lovFormObjectWithNames
                
                // ─── Section (LOV) ────────────────────────────────────
                'section_no'      => $request->input('section_no'),
                'section_name'    => $request->input('section_no_name'),
                
                // ─── Floor (LOV) ──────────────────────────────────────
                'floor_id'        => $request->input('floor_id'),
                'floor_desc'      => $request->input('floor_id_name'),
                
                // ─── Line (LOV) ───────────────────────────────────────
                'line'            => $request->input('line'),
                'line_info'       => $request->input('line_name'),
                
                // ─── Designation (LOV) ────────────────────────────────
                'des_id'          => $request->input('des_id'),
                'des_name'        => $request->input('des_id_name'),
                
                // ─── Grade (LOV) ──────────────────────────────────────
                'grade_id'        => $request->input('grade_id'),
                'grade_name'      => $request->input('grade_id_name'),
                
                // ─── Shift (LOV) ──────────────────────────────────────
                'shift_code'      => $request->input('shift_code'),
                'shift_name'      => $request->input('shift_code_name'),
                
                // ─── Calendar (LOV) ───────────────────────────────────
                'cal_code'        => $request->input('cal_code'),
                
                // ─── Weekly Off (LOV) ─────────────────────────────────
                'weekly_off'      => $request->input('weekly_off'),
                
                // ─── Shift Group ──────────────────────────────────────
                's_group_name'    => $request->input('s_group_name'),
                
                // ─── Joining & Date Information ───────────────────────
                'joining_date'       => Carbon::createFromFormat('d-m-Y', $request->input('join_date'))
                              ->format('Y-m-d'),
                'join_time'       => $request->input('join_time'),
                'conform_date' => $request->input('confirmation_date'),
                'confirmation_duration' => $request->input('confirmation_duration'),
                'last_promo_date' => $request->input('last_promo_date'),
                'last_increment_date' => $request->input('last_increment_date'),
                
                // ─── Attendance & Card Information ────────────────────
                'punch_card_no'   => $request->input('punch_card_no'),
                'proximity_card_no' => $request->input('proximity_card_no'),
                'ot_cat'          => $request->input('ot_cat'),
                'attn_eff_date'   => $request->input('attn_eff_date'),
                
                // ─── Leave Information (LOV) ──────────────────────────
                'lv_cat_id'       => $request->input('lv_cat_id'),
                'lv_cat_name'     => $request->input('lv_cat_id_name'),
                'entry_date'      => $request->input('entry_date'),
                
                // ─── Salary & Bank Information ────────────────────────
                'gross'           => $request->input('gross'),
                'other_allowance' => $request->input('other_allowance'),
                'bank_name'       => $request->input('bank_name'), // LOV value = text in this case
                'bank_ac_no'      => $request->input('bank_ac_no'),
                'tin_no'          => $request->input('tin_no'),
                'tax_deduction'   => $request->input('tax_deduction'),
                'service_book_number' => $request->input('service_book_number'),
                'ac_no'           => $request->input('ac_no'),
                
                // ─── Release Information ──────────────────────────────
                'termination_date' => $request->input('termination_date'),
                'resigned_date'   => $request->input('resigned_date'),
                'reason'          => $request->input('reason'),
                'is_lefty'        => $request->input('is_lefty'),
                
                // ─── Audit Fields ─────────────────────────────────────
                'update_by'       => auth()->id() ?? 1,
                'update_date'     => now(),
            ];
            
            // Remove null values to avoid overwriting existing data with nulls
            $data = array_filter($data, function($value) {
                return $value !== null && $value !== '';
            });
            
            // ─────────────────────────────────────────────────────────
            //  Update or Create Record
            // ─────────────────────────────────────────────────────────
            if ($record) {
                $record->update($data);
                
                // Log for debugging (remove in production)
                \Log::info('Official Info Updated', [
                    'empno' => $empno,
                    'dept' => $data['dept_no'] ?? null,
                    'dept_name' => $data['dept_name'] ?? null,
                ]);
                
                return response()->json([
                    'success' => true, 
                    'message' => 'Official information updated successfully',
                    'data' => [
                        'empno' => $empno,
                        'dept_name' => $data['dept_name'] ?? null,
                        'des_name' => $data['des_name'] ?? null,
                    ]
                ], 200);
            }
            
            // For new records, add insert audit fields
            $data['insert_by'] = auth()->id() ?? 1;
            $data['insert_date'] = now();
            
            $newRecord = EmpOfficial::create($data);
            
            // Log for debugging (remove in production)
            \Log::info('Official Info Created', [
                'empno' => $empno,
                'dept' => $data['dept_no'] ?? null,
                'dept_name' => $data['dept_name'] ?? null,
            ]);
            
            return response()->json([
                'success' => true, 
                'message' => 'Official information saved successfully',
                'data' => [
                    'empno' => $empno,
                    'dept_name' => $data['dept_name'] ?? null,
                    'des_name' => $data['des_name'] ?? null,
                ]
            ], 201);
            
        } catch(\Illuminate\Database\QueryException $e) {
            // Database specific errors
            \Log::error('Database Error in saveEmpOfficial', [
                'empno' => $request->input('empno'),
                'error' => $e->getMessage(),
                'sql' => $e->getSql() ?? 'N/A'
            ]);
            
            return response()->json([
                'success' => false, 
                'message' => 'Database error: ' . $e->getMessage()
            ], 500);
            
        } catch(\Exception $e) {
            // General errors
            \Log::error('Error in saveEmpOfficial', [
                'empno' => $request->input('empno'),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false, 
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    // ═════════════════════════════════════════════════════════════════════
    //  GET OFFICIAL DATA (Helper method to retrieve official info with names)
    // ═════════════════════════════════════════════════════════════════════
    public function getEmpOfficial($empno) {
        if(!session('LoggedUser')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        
        try {
            $official = EmpOfficial::where('empno', $empno)->first();
            
            if (!$official) {
                return response()->json([
                    'success' => false,
                    'message' => 'Official record not found'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'data' => $official
            ]);
            
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // ─────────────────────────────────────────────────────
    //  AUTOCOMPLETE / SEARCH
    // ─────────────────────────────────────────────────────
    public function empsearch(Request $request) {
        $rows = DB::table('EMP_PERSONAL')
            ->select('NEW_EMPNO')
            ->where('NEW_EMPNO','like','%'.$request->search_key.'%')
            ->take(20)->get();
        return response()->json(['data'=>$rows]);
    }

    public function getEmpDetSearch(Request $request) {
        return EmpPersonal::where('new_empno','=',$request->empno)
            ->with('getempofficial','getemploc','empQualification',
                   'getEmpShortModel','getEmpFamily','getEmpHistory',
                   'getEmpTraining','getEmpWorkExp')
            ->get();
    }

    public function empSearchExist(Request $request) {
        return DB::table('EMP_PERSONAL')
            ->select(DB::raw('COUNT(EMPNO) as EMPCOUNT'))
            ->where('EMPNO','=',$request->input('empno'))->get();
    }

    // ─────────────────────────────────────────────────────
    //  LEAVE (unchanged)
    // ─────────────────────────────────────────────────────
    public function getLeaveDetails($empno,$year) {
        $rows = DB::table('LEAVE_ENTRY_DETAILS')->where('YEAR','=',$year)->where('EMPNO','=',$empno)->get();
        return view('hrm.leave_table',['getLeaveDetails'=>$rows]);
    }
    
    public function getLeavePrebal($empno,$year,$lv) {
        return DB::table(DB::raw('LEAVE_ENTRY_DETAILS LV'))
            ->select(DB::raw('NVL(SUM(APPROVE_DAYS),0) APPROVE_DAYS'))
            ->where('LV.leave_id','=',$lv)->where('empno','=',$empno)
            ->whereRaw('\''.$year.'\' = to_char(lv_to,\'YYYY\')')
            ->whereRaw('\''.$year.'\' = to_char(lv_from,\'YYYY\')')->get();
    }
    
    public function getLeavBal($lv) {
        return DB::table('leave_info')->select(DB::raw('nvl(max_days,60)max_days'))->where('leave_id','=',$lv)->get();
    }
    
    public function leaveEntryIns(Request $request) {
        $d=$request->input();
        $c=DB::table('LEAVE_ENTRY_MASTER')->selectRaw('COUNT(*) AS COUNT_LEAVE')
            ->where('YEAR','=',$d['year'])->where('EMPNO','=',$d['empno'])
            ->where('COMPANY_ID','=',$d['company_id'])->first();
        if(optional($c)->count_leave>0) return response()->json(['status'=>200]);
        try {
            $l=new LeaveEntryMaster;
            $l->company_id=$d['company_id']; $l->empno=$d['empno'];
            $l->lv_cat_id=$d['lv_cat_id'];   $l->new_empno=$d['empno'];
            $l->year=$d['year']; $l->save();
            return response()->json(['status'=>200]);
        } catch(\Exception $e){ return $e; }
    }
    
    public function leaveEntryDet(Request $request) {
        $d=$request->input();
        $max=DB::table('LEAVE_ENTRY_details')->select(DB::raw('(nVL(MAX(LV_SL),0)+1) lv_sl'))
            ->where('YEAR','=',$d['year_det'])->where('EMPNO','=',$d['emp_no_det'])
            ->where('lv_cat_id','=',$d['lv_cat_id_det'])->first();
        try {
            $l=new LeaveEntryDetails;
            $l->lv_cat_id=$d['lv_cat_id_det']; $l->year=$d['year_det']; $l->empno=$d['emp_no_det'];
            $l->balance=$d['new_balance'];       $l->application_date=$d['submitted'];
            $l->approve_date=$d['approve_date']; $l->approve_days=$d['approve_days'];
            $l->approve_by=$d['approve_by'];     $l->lv_from=$d['lv_from'];
            $l->lv_to=$d['lv_to'];               $l->leave_id=$d['leave_name'];
            $l->max_days=$d['max_days'];          $l->pre_balance=$d['pre_balance'];
            $l->remax=$d['remarks'];              $l->information=$d['information'];
            $l->lv_sl=$max->lv_sl; $l->save();
            return response()->json(['status'=>200]);
        } catch(\Exception $e){ return $e; }
    }
    
    public function deleteLeave($empno,$year,$sl) {
        $r=DB::table('LEAVE_ENTRY_details')->select('lv_sl')
            ->where('YEAR','=',$year)->where('EMPNO','=',$empno)->where('lv_sl','=',$sl)->first();
        if(!optional($r)->lv_sl==null) {
            try {
                DB::table('LEAVE_ENTRY_details')
                    ->where('YEAR','=',$year)->where('EMPNO','=',$empno)->where('lv_sl','=',$sl)->delete();
                return response()->json(['status2'=>200]);
            } catch(\Exception $e){ return response()->json([$e->getCode()]); }
        }
    }
    
    public function logout() { 
        session()->pull('LoggedUser'); 
        return redirect('login'); 
    }
}