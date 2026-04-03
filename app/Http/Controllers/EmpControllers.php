<?php

namespace App\Http\Controllers;

use App\Models\EmpOfficial;
use App\Models\EmpPersonal;
use App\Models\Emp_familyModel;
use App\Models\Emp_historyModel;
use App\Models\Emp_locationModel;
use App\Models\EmpLocation;
use Illuminate\Support\Facades\Validator;


use App\Models\Emp_qualificationModel;
use App\Models\Emp_ShortModel;
use App\Models\Emp_trainingModel;
use App\Models\Emp_work_expModel;
use App\Models\IncrementDetailsModel;
use App\Models\LeaveEntryMaster;
use App\Models\LeaveEntryDetails;
use League\Flysystem\Ftp\FtpAdapter;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use Intervention\Image\Facades\Image;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Session;
use Illuminate\Support\Str;

class EmpControllers extends Controller
{


    public function empentry(Request $request)
    {
        $uri = Route::getFacadeRoot()->current()->uri();

        if (!session('LoggedUser') == null) {try
            {
                $yaerList = DB::table('DUAL')
                    ->select(DB::raw('TO_CHAR(SYSDATE,\'YYYY\')-LEVEL+1 YEAR'))
                    ->whereRaw('TO_CHAR(SYSDATE,\'YYYY\')-LEVEL+1 > \'1985\'CONNECT BY LEVEL <=80')
                    ->get();
                $companyList = DB::table('COMPANY_PROFILE')
                    ->select('COMPANY_ID', 'COMPANY_NAME')
                    ->orderBy('COMPANY_ID', 'desc')
                    ->get();
                $deptList = DB::table('DEPT')
                    ->orderBy('DEPT_NO', 'asc')
                //  ->pluck('dept_no','dept_name');
                    ->get();
                $floorList = DB::table('FLOOR')
                    ->orderBy('Floor_id', 'asc')
                //  ->pluck('dept_no','dept_name');
                    ->get();

                $LineInfo = DB::table('LINE_INFO')
                    ->orderBy('LINE', 'asc')
                //  ->pluck('dept_no','dept_name');
                    ->get();
                $designation = DB::table('DESIGNATION_DETAILS')
                    ->select('DES_ID', 'DESIGNATION_NAME', 'IN_SHORT', 'GRADE_ID', 'IN_BENGALI', 'BNS_AMNT', 'NIGHT_BILL')
                    ->get();

                $sectionList = DB::table('SECTION')
                    ->orderBy('SECTION_NO', 'asc')
                    ->get();
                $religion = DB::table('RELIGION')
                    ->select('RELIGION_NAME', 'RELIGION_ID')
                    ->orderBy('RELIGION_ID', 'asc')
                    ->get();
                $data = DB::table('ALL_USER_INFO')
                    ->select('USER_ID', 'EMPLOYEE_ID', 'USER_GROUP_ID', 'INITIAL_PASSWORD', 'COMPANY_ID', 'USER_MOBILE',
                        DB::raw('"GET_EMP_NAME"(EMPLOYEE_ID) as EMPLOYEE_NAME'))
                    ->where('EMPLOYEE_ID', '=', session('LoggedUser'))
                    ->get();
                $leftmenu = DB::table('ALL_USER_GROUP_DETAILS')
                    ->crossJoin('ALL_MENU_HIERARCHY')
                    ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'TITLE', 'DESCRIPTION')
                    ->where('ALL_USER_GROUP_DETAILS.ENABLED', '=', 'Y')
                    ->where('ALL_MENU_HIERARCHY.CHILD_ID', '=', DB::raw('ALL_USER_GROUP_DETAILS.MENU_ITEM_ID'))
                    ->get();
                $submenu = DB::table('ALL_USER_SUB_DETAILS')
                    ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'SUB_MENU_ID', 'SUB_MENU_1', 'SUB_MENU_2', 'SUB_MENU_NAME', 'ROUTE')
                    ->whereNull('SUB_MENU_2')
                    ->get();
                $submenu2 = DB::table('ALL_USER_SUB_DETAILS')
                    ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'SUB_MENU_ID', 'SUB_MENU_1', 'SUB_MENU_2', 'SUB_MENU_NAME', 'ROUTE')
                    ->whereNotNull('SUB_MENU_2')
                    ->get();
                $headeer = DB::table('ALL_USER_SUB_DETAILS')
                    ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'SUB_MENU_ID', 'SUB_MENU_1', 'SUB_MENU_2', 'SUB_MENU_NAME', 'ROUTE')
                    ->where('ROUTE', '=', $uri)
                    ->get();
                $empdetailsget = DB::table('EMP_PERSONAL')
                    ->select('EMPNO', 'FIRST_NAME')
                    ->where('NEW_EMPNO', '=', $request->search_emp)
                    ->first();
//return json_encode($deptList);
                //        dd($ll)   ;
                $empType = DB::table('HRM.EMP_TYPE')
                    ->select('EMP_TYPE', 'TYPE_SET', 'PRIORITY')
                    ->get();
                $shiftInfo = DB::table('HRM.SHIFT_INFO')
                    ->select('SHIFT_CODE', 'SHIFT_NAME', 'IN_TIME', 'OUT_TIME', 'GRACE_PERIOD', 'MEAL_TIME', 'SIN_TIME', 'SOUT_TIME', 'OT_LIMIT', 'SHIFT_IN_TIME', 'GRACE_PERIOD_2')
                    ->get();
                $gradeInfo = DB::table('HRM.GRADE')
                    ->select('GRADE_ID', 'GRADE_NAME', 'GRADE_TYPE')
                    ->get();
                $calInfo = DB::table('HRM.CALENDER_MASTER')
                    ->select('CAL_CODE', 'IS_CLOSE')
                    ->where('is_close', '=', 'N')
                    ->get();
                $leaveCat = DB::table('LV_CAT_MASTER')
                    ->select('LV_CAT_ID')
                    ->get();
                $bankNmae = DB::table('BANK')
                    ->select('BANK_NAME')
                    ->get();

                    $upazilla=DB::table('HRM.UPAZILAS')
                    ->select('ID','DISTRICT_ID','NAME','BN_NAME')
                    ->orderBy('Name','ASC')
                    ->get();

                    $district=DB::table('HRM.DISTRICT')
                    ->select('DISTRICT','DISTRICT_ID')
                    ->orderBy('DISTRICT','ASC')
                    ->get();
                    //dd($floorList);

                return view('hrm.empentry', ['district2'=>$district,'district'=>$district,'upazilla'=>$upazilla,'data' => $data, 'menu' => $leftmenu, 'submenu' => $submenu, 'submenu2' => $submenu2, 'headeer' => $headeer, 'religion' => $religion, 'companyList' => $companyList,
                    'section_list' => $sectionList, 'deptList' => $deptList, 'floorList' => $floorList, 'lineInfo' => $LineInfo, 'empType' => $empType, 'shiftInfo' => $shiftInfo,
                    'gradeInfo' => $gradeInfo, 'calInfo' => $calInfo, 'leaveCat' => $leaveCat, 'bankNmae' => $bankNmae, 'designation' => $designation]);
            } catch (Exception $e) {
                dd($e->getMessage());
            }} else {
            return redirect('login');
        }
    }
    public function empnewentryfind(Request $request)
    {
        $uri = Route::getFacadeRoot()->current()->uri();

        if (!session('LoggedUser') == null) {
            
            try
            { $companyList = DB::table('COMPANY_PROFILE')
                    ->get();
                $religion = DB::table('RELIGION')
                    ->select('RELIGION_NAME', 'RELIGION_ID')
                    ->get();
                $data = DB::table('ALL_USER_INFO')
                    ->select('USER_ID', 'EMPLOYEE_ID', 'USER_GROUP_ID', 'INITIAL_PASSWORD', 'COMPANY_ID', 'USER_MOBILE',
                        DB::raw('"GET_EMP_NAME"(EMPLOYEE_ID) as EMPLOYEE_NAME'))
                    ->where('EMPLOYEE_ID', '=', session('LoggedUser'))
                    ->get();
                $leftmenu = DB::table('ALL_USER_GROUP_DETAILS')
                    ->crossJoin('ALL_MENU_HIERARCHY')
                    ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'TITLE', 'DESCRIPTION')
                    ->where('ALL_USER_GROUP_DETAILS.ENABLED', '=', 'Y')
                    ->where('ALL_MENU_HIERARCHY.CHILD_ID', '=', DB::raw('ALL_USER_GROUP_DETAILS.MENU_ITEM_ID'))
                    ->get();
                $submenu = DB::table('ALL_USER_SUB_DETAILS')
                    ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'SUB_MENU_ID', 'SUB_MENU_1', 'SUB_MENU_2', 'SUB_MENU_NAME', 'ROUTE')
                    ->whereNull('SUB_MENU_2')
                    ->get();
                $headeer = DB::table('ALL_USER_SUB_DETAILS')
                    ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'SUB_MENU_ID', 'SUB_MENU_1', 'SUB_MENU_2', 'SUB_MENU_NAME', 'ROUTE')
                    ->where('ROUTE', '=', $uri)
                    ->get();

                $submenu2 = DB::table('ALL_USER_SUB_DETAILS')
                    ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'SUB_MENU_ID', 'SUB_MENU_1', 'SUB_MENU_2', 'SUB_MENU_NAME', 'ROUTE')
                    ->whereNotNull('SUB_MENU_2')
                    ->get();
                $empdetailsget = DB::table('EMP_PERSONAL')
                    ->select('*')
                    ->where('NEW_EMPNO', '=', $request->search_emp)
                    ->get();
                dd($submenu);
                return view('hrm.empentryfind', ['data' => $data, 'menu' => $leftmenu, 'submenu' => $submenu, 'submenu2' => $submenu2, 'headeer' => $headeer, 'empdetailsget' => $empdetailsget, 'companyList' => $companyList]);
            } catch (Exception $e) {
                dd($e->getMessage());
            }} else {
            return redirect('login');
        }
    }
    public function logout()
    {
        if (session()->has('LoggedUser')) {
            session()->pull('LoggedUser');
            return redirect('login');
        }}

    public function empsearch(Request $request)
    {

        $empno = DB::table('EMP_PERSONAL')
            ->select('NEW_EMPNO')
            ->where('NEW_EMPNO', 'like', '%' . $request->search_key . '%')
            ->take(20)->get();
        return response()->json(['data' => $empno]);
    }

    public function getEmpDetSearch(Request $request)
    {
        $dt = EmpPersonal::where('new_empno', '=', $request->empno)
            ->with('getempofficial', 'getemploc', 'empQualification',
                'getEmpShortModel', 'getEmpFamily', 'getEmpHistory', 'getEmpTraining', 'getEmpWorkExp')
            ->get();

        //  $arrayVar = $dt->toArray();

        return $dt;
        //return view('demo',['empdt'=>$dt]);
    }

    public function saveEmpPersonal(Request $request)
    {
          $empno = trim($request->input('empno'));
// dd($request->all());
            // Check if employee exists
            $empPersonal = EmpPersonal::where('empno', $empno)->first();
        try {
            $validator = Validator::make($request->all(), [
                'empno' => 'required|string',
                'first_name' => 'nullable|string|max:100',
                'middle_name' => 'nullable|string|max:100',
                'last_name' => 'nullable|string|max:100',
                'b_name' => 'nullable|string|max:255',
                'father_name' => 'nullable|string|max:100',
                'mother_name' => 'nullable|string|max:100',
                'gurdian_name' => 'nullable|string|max:100',
                'dob' => 'nullable|date',
                'sex' => 'nullable|string|max:10',
                'marial_status' => 'nullable|string|max:50',
                'religion_id' => 'nullable|integer',
                'blood_group' => 'nullable|string|max:10',
                'national_id_no' => 'nullable|string|max:100',
                'id_card_issue' => 'nullable|date',
                'valid_till' => 'nullable|date',
                'passport_no' => 'nullable|string|max:100',
                'place_of_issue' => 'nullable|string|max:100',
                'company_id' => 'nullable|integer',
                'as_on' => 'nullable|date',
                'emp_mobile_no' => 'nullable|string|max:20',
                'sms_mobile_no' => 'nullable|string|max:20',
            ]);
 
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
 
          
 
            $personalData = [
                'empno' => $empno,
                'first_name' => $request->input('first_name'),
                'middle_name' => $request->input('middle_name'),
                'last_name' => $request->input('last_name'),
                'b_name' => $request->input('b_name'),
                'father_name' => $request->input('father_name'),
                'mother_name' => $request->input('mother_name'),
                'gurdian_name' => $request->input('gurdian_name'),
                'dob' => $request->input('dob'),
                'sex' => $request->input('sex'),
                'marial_status' => $request->input('marial_status'),
                'religion_id' => $request->input('religion_id'),
                'blood_group' => $request->input('blood_group'),
                'national_id_no' => $request->input('national_id_no'),
                'id_card_issue' => $request->input('id_card_issue'),
                'valid_till' => $request->input('valid_till'),
                'passport_no' => $request->input('passport_no'),
                'place_of_issue' => $request->input('place_of_issue'),
                'company_id' => $request->input('company_id'),
                'as_on' => $request->input('as_on'),
                'emp_mobile_no' => $request->input('emp_mobile_no'),
                'sms_mobile_no' => $request->input('sms_mobile_no'),
                'update_by' => auth()->id() ?? 1,
                'update_date' => now(),
            ];
 
            if ($empPersonal) {
                // Update existing employee
                $empPersonal->update($personalData);
                $message = 'Employee personal information updated successfully';
                $statusCode = 200;
            } else {
                // Create new employee
                $personalData['insert_by'] = auth()->id() ?? 1;
                $personalData['insert_date'] = now();
                $empPersonal = EmpPersonal::create($personalData);
                $message = 'Employee personal information saved successfully';
                $statusCode = 201;
            }
 
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $empPersonal
            ], $statusCode);
 
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error processing employee personal information',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function saveEmpOfficial(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'empno' => 'required|string',
                'company_id' => 'nullable|integer',
                'company_name' => 'nullable|string|max:255',
                'dept_no' => 'nullable|string|max:50',
                'dept_name' => 'nullable|string|max:100',
                'section_no' => 'nullable|string|max:50',
                'section_name' => 'nullable|string|max:100',
                'emp_type' => 'nullable|string|max:50',
                'des_id' => 'nullable|integer',
                'des_name' => 'nullable|string|max:100',
                'grade_id' => 'nullable|string|max:50',
                'grade_name' => 'nullable|string|max:100',
                'joining_date' => 'nullable|date',
                'conform_date' => 'nullable|date',
                'termination_date' => 'nullable|date',
                'resigned_date' => 'nullable|date',
                'weekly_off' => 'nullable|string|max:50',
                'shift_code' => 'nullable|string|max:50',
                'shift_name' => 'nullable|string|max:100',
                'cal_code' => 'nullable|string|max:50',
                'floor_id' => 'nullable|integer',
                'line' => 'nullable|string|max:50',
                'line_info' => 'nullable|string|max:255',
                'bank_name' => 'nullable|string|max:100',
                'bank_ac_no' => 'nullable|string|max:100',
                'tin_no' => 'nullable|string|max:50',
                'work_ent' => 'nullable|in:Y,N',
                'ot_ent' => 'nullable|in:Y,N',
                'tran_ent' => 'nullable|in:Y,N',
                'res_ent' => 'nullable|in:Y,N',
                'pf_ent' => 'nullable|in:Y,N',
                'tax_ent' => 'nullable|in:Y,N',
                'pes_ent' => 'nullable|in:Y,N',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $empno = $request->input('empno');

            // Check if official record exists
            $empOfficial = EmpOfficial::where('empno', $empno)->first();

            $officialData = [
                'empno' => $empno,
                'company_id' => $request->input('company_id'),
                'company_name' => $request->input('company_name'),
                'dept_no' => $request->input('dept_no'),
                'dept_name' => $request->input('dept_name'),
                'section_no' => $request->input('section_no'),
                'section_name' => $request->input('section_name'),
                'emp_type' => $request->input('emp_type'),
                'des_id' => $request->input('des_id'),
                'des_name' => $request->input('des_name'),
                'grade_id' => $request->input('grade_id'),
                'grade_name' => $request->input('grade_name'),
                'joining_date' => $request->input('joining_date'),
                'conform_date' => $request->input('conform_date'),
                'termination_date' => $request->input('termination_date'),
                'resigned_date' => $request->input('resigned_date'),
                'weekly_off' => $request->input('weekly_off'),
                'shift_code' => $request->input('shift_code'),
                'shift_name' => $request->input('shift_name'),
                'cal_code' => $request->input('cal_code'),
                'floor_id' => $request->input('floor_id'),
                'line' => $request->input('line'),
                'line_info' => $request->input('line_info'),
                'bank_name' => $request->input('bank_name'),
                'bank_ac_no' => $request->input('bank_ac_no'),
                'tin_no' => $request->input('tin_no'),
                'work_ent' => $request->input('work_ent'),
                'ot_ent' => $request->input('ot_ent'),
                'tran_ent' => $request->input('tran_ent'),
                'res_ent' => $request->input('res_ent'),
                'pf_ent' => $request->input('pf_ent'),
                'tax_ent' => $request->input('tax_ent'),
                'pes_ent' => $request->input('pes_ent'),
                'update_by' => auth()->id() ?? 1,
            ];

            if ($empOfficial) {
                $empOfficial->update($officialData);
                $message = 'Employee official information updated successfully';
                $statusCode = 200;
            } else {
                $empOfficial = EmpOfficial::create($officialData);
                $message = 'Employee official information saved successfully';
                $statusCode = 201;
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $empOfficial
            ], $statusCode);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error processing employee official information',
                'error' => $e->getMessage()
            ], 500);
        }
    }
public function saveEmpLocation(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'empno' => 'required|string',
                'p_address' => 'nullable|string|max:500',
                'p_city' => 'nullable|string|max:100',
                'p_district' => 'nullable|string|max:100',
                'p_pin_code' => 'nullable|string|max:20',
                'p_phone' => 'nullable|string|max:20',
                'p_fax' => 'nullable|string|max:20',
                'p_cperson' => 'nullable|string|max:100',
                'p_village' => 'nullable|string|max:100',
                'p_post_off' => 'nullable|string|max:100',
                'p_police_station' => 'nullable|string|max:100',
                'r_address' => 'nullable|string|max:500',
                'r_city' => 'nullable|string|max:100',
                'r_district' => 'nullable|string|max:100',
                'r_pin_cod' => 'nullable|string|max:20',
                'r_phone' => 'nullable|string|max:20',
                'r_fax' => 'nullable|string|max:20',
                'r_mobile' => 'nullable|string|max:20',
                'r_email' => 'nullable|email|max:100',
                'r_cperson' => 'nullable|string|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $empno = $request->input('empno');

            $empLocation = EmpLocation::where('empno', $empno)->first();

            $locationData = [
                'empno' => $empno,
                'p_address' => $request->input('p_address'),
                'p_city' => $request->input('p_city'),
                'p_district' => $request->input('p_district'),
                'p_pin_code' => $request->input('p_pin_code'),
                'p_phone' => $request->input('p_phone'),
                'p_fax' => $request->input('p_fax'),
                'p_cperson' => $request->input('p_cperson'),
                'p_village' => $request->input('p_village'),
                'p_post_off' => $request->input('p_post_off'),
                'p_police_station' => $request->input('p_police_station'),
                'r_address' => $request->input('r_address'),
                'r_city' => $request->input('r_city'),
                'r_district' => $request->input('r_district'),
                'r_pin_cod' => $request->input('r_pin_cod'),
                'r_phone' => $request->input('r_phone'),
                'r_fax' => $request->input('r_fax'),
                'r_mobile' => $request->input('r_mobile'),
                'r_email' => $request->input('r_email'),
                'r_cperson' => $request->input('r_cperson'),
            ];

            if ($empLocation) {
                $empLocation->update($locationData);
                $message = 'Employee location information updated successfully';
                $statusCode = 200;
            } else {
                $empLocation = EmpLocation::create($locationData);
                $message = 'Employee location information saved successfully';
                $statusCode = 201;
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $empLocation
            ], $statusCode);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error processing employee location information',
                'error' => $e->getMessage()
            ], 500);
        }
    }
 public function saveEmpQualification(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'empno' => 'required|string',
                'name_of_ins' => 'nullable|string|max:255',
                'passed_exam' => 'nullable|string|max:100',
                'division' => 'nullable|string|max:50',
                'year' => 'nullable|integer',
                'board' => 'nullable|string|max:100',
                'marks' => 'nullable|string|max:50',
                'subject' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $empno = $request->input('empno');

            $qualification = Emp_qualificationModel::create([
                'empno' => $empno,
                'name_of_ins' => $request->input('name_of_ins'),
                'passed_exam' => $request->input('passed_exam'),
                'division' => $request->input('division'),
                'year' => $request->input('year'),
                'board' => $request->input('board'),
                'marks' => $request->input('marks'),
                'subject' => $request->input('subject'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Employee qualification saved successfully',
                'data' => $qualification
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving employee qualification',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function saveEmpShortCourse(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'empno' => 'required|string',
                'course_name' => 'nullable|string|max:255',
                'conducted_by' => 'nullable|string|max:255',
                'c_from' => 'nullable|date',
                'c_to' => 'nullable|date',
                'certificate' => 'nullable|string|max:255',
                'total_day' => 'nullable|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $empno = $request->input('empno');

            $shortCourse = Emp_ShortModel::create([
                'empno' => $empno,
                'course_name' => $request->input('course_name'),
                'conducted_by' => $request->input('conducted_by'),
                'c_from' => $request->input('c_from'),
                'c_to' => $request->input('c_to'),
                'certificate' => $request->input('certificate'),
                'total_day' => $request->input('total_day'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Employee short course saved successfully',
                'data' => $shortCourse
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving employee short course',
                'error' => $e->getMessage()
            ], 500);
        }
    }
 public function saveEmpFamily(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'empno' => 'required|string',
                'depd_no' => 'nullable|string|max:50',
                'depd_name' => 'required|string|max:100',
                'relationship' => 'nullable|string|max:50',
                'd_dob' => 'nullable|date',
                'd_age' => 'nullable|integer',
                'd_sex' => 'nullable|string|max:10',
                'd_as_on' => 'nullable|date',
                'percentage' => 'nullable|numeric',
                'address' => 'nullable|string|max:500',
                'depent_name_bangla' => 'nullable|string|max:255',
                'relation_bn' => 'nullable|string|max:100',
                'address_bn' => 'nullable|string|max:500',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $empno = $request->input('empno');

            $family = Emp_familyModel::create([
                'empno' => $empno,
                'depd_no' => $request->input('depd_no'),
                'depd_name' => $request->input('depd_name'),
                'relationship' => $request->input('relationship'),
                'd_dob' => $request->input('d_dob'),
                'd_age' => $request->input('d_age'),
                'd_sex' => $request->input('d_sex'),
                'd_as_on' => $request->input('d_as_on'),
                'percentage' => $request->input('percentage'),
                'address' => $request->input('address'),
                'depent_name_bangla' => $request->input('depent_name_bangla'),
                'relation_bn' => $request->input('relation_bn'),
                'address_bn' => $request->input('address_bn'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Employee family information saved successfully',
                'data' => $family
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving employee family information',
                'error' => $e->getMessage()
            ], 500);
        }
    }
public function saveEmpHistory(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'empno' => 'required|string',
                'join_as' => 'nullable|string|max:100',
                'work_location' => 'nullable|string|max:100',
                'join_date' => 'nullable|date',
                'designation' => 'nullable|string|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $empno = $request->input('empno');

            $history = Emp_historyModel::create([
                'empno' => $empno,
                'join_as' => $request->input('join_as'),
                'work_location' => $request->input('work_location'),
                'join_date' => $request->input('join_date'),
                'designation' => $request->input('designation'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Employee history saved successfully',
                'data' => $history
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving employee history',
                'error' => $e->getMessage()
            ], 500);
        }
    }
     public function saveEmpTraining(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'empno' => 'required|string',
                't_title' => 'nullable|string|max:255',
                't_conducted_by' => 'nullable|string|max:255',
                't_from' => 'nullable|date',
                't_to' => 'nullable|date',
                't_certificate' => 'nullable|string|max:255',
                'skill_type' => 'nullable|string|max:100',
                'to_days' => 'nullable|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $empno = $request->input('empno');

            $training = Emp_trainingModel::create([
                'empno' => $empno,
                't_title' => $request->input('t_title'),
                't_conducted_by' => $request->input('t_conducted_by'),
                't_from' => $request->input('t_from'),
                't_to' => $request->input('t_to'),
                't_certificate' => $request->input('t_certificate'),
                'skill_type' => $request->input('skill_type'),
                'to_days' => $request->input('to_days'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Employee training saved successfully',
                'data' => $training
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving employee training',
                'error' => $e->getMessage()
            ], 500);
        }
    }

 public function saveEmpWorkExp(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'empno' => 'required|string',
                'organization' => 'required|string|max:255',
                'd_from' => 'required|date',
                'd_to' => 'nullable|date',
                'leave_reason' => 'nullable|string|max:500',
                'prv_emp_no' => 'nullable|string|max:50',
                'org_address' => 'nullable|string|max:500',
                'org_tel' => 'nullable|string|max:20',
                'last_sal_drawn' => 'nullable|numeric',
                'total_years' => 'nullable|numeric',
                'designation' => 'nullable|string|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $empno = $request->input('empno');

            $workExp = Emp_work_expModel::create([
                'empno' => $empno,
                'organization' => $request->input('organization'),
                'd_from' => $request->input('d_from'),
                'd_to' => $request->input('d_to'),
                'leave_reason' => $request->input('leave_reason'),
                'prv_emp_no' => $request->input('prv_emp_no'),
                'org_address' => $request->input('org_address'),
                'org_tel' => $request->input('org_tel'),
                'last_sal_drawn' => $request->input('last_sal_drawn'),
                'total_years' => $request->input('total_years'),
                'designation' => $request->input('designation'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Employee work experience saved successfully',
                'data' => $workExp
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving employee work experience',
                'error' => $e->getMessage()
            ], 500);
        }
    }

public function getEmpDetails(Request $request)
    {
        try {
            $empno = $request->query('empno');

            if (!$empno) {
                return response()->json([
                    'success' => false,
                    'message' => 'Employee number is required'
                ], 400);
            }

            $employee = EmpPersonal::where('empno', $empno)
                ->with([
                    'getempofficial',
                    'getemploc',
                    'empQualification',
                    'getEmpShortModel',
                    'getEmpFamily',
                    'getEmpHistory',
                    'getEmpTraining',
                    'getEmpWorkExp'
                ])
                ->first();

            if (!$employee) {
                return response()->json([
                    'success' => false,
                    'message' => 'Employee not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $employee
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching employee details',
                'error' => $e->getMessage()
            ], 500);
        }
    }
public function getEmpQualifications($empno)
    {
        try {
            $qualifications = Emp_qualificationModel::where('empno', $empno)->get();

            return response()->json([
                'success' => true,
                'data' => $qualifications
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching qualifications',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getEmpShortCourses($empno)
    {
        try {
            $courses = Emp_ShortModel::where('empno', $empno)->get();

            return response()->json([
                'success' => true,
                'data' => $courses
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching short courses',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getEmpFamily($empno)
    {
        try {
            $family = Emp_familyModel::where('empno', $empno)->get();

            return response()->json([
                'success' => true,
                'data' => $family
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching family information',
                'error' => $e->getMessage()
            ], 500);
        }
    }
     public function getEmpHistory($empno)
    {
        try {
            $history = Emp_historyModel::where('empno', $empno)->get();

            return response()->json([
                'success' => true,
                'data' => $history
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching history',
                'error' => $e->getMessage()
            ], 500);
        }
    }
public function getEmpTrainings($empno)
    {
        try {
            $trainings = Emp_trainingModel::where('empno', $empno)->get();

            return response()->json([
                'success' => true,
                'data' => $trainings
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching trainings',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Employee Work Experience
     * 
     * @param $empno
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEmpWorkExperience($empno)
    {
        try {
            $workExp = Emp_work_expModel::where('empno', $empno)->get();

            return response()->json([
                'success' => true,
                'data' => $workExp
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching work experience',
                'error' => $e->getMessage()
            ], 500);
        }
    }

public function deleteEmpRecord($id, Request $request)
    {
        try {
            $type = $request->query('type'); // qualification, course, family, etc.

            if (!$type) {
                return response()->json([
                    'success' => false,
                    'message' => 'Record type is required'
                ], 400);
            }

            $deleted = false;

            switch($type) {
                case 'qualification':
                    $deleted = Emp_qualificationModel::where('id', $id)->delete();
                    break;
                case 'course':
                    $deleted = Emp_ShortModel::where('id', $id)->delete();
                    break;
                case 'family':
                    $deleted = Emp_familyModel::where('id', $id)->delete();
                    break;
                case 'history':
                    $deleted = Emp_historyModel::where('id', $id)->delete();
                    break;
                case 'training':
                    $deleted = Emp_trainingModel::where('id', $id)->delete();
                    break;
                case 'workexp':
                    $deleted = Emp_work_expModel::where('id', $id)->delete();
                    break;
                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid record type'
                    ], 400);
            }

            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => 'Record deleted successfully'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Record not found'
                ], 404);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting record',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function increment_details()
    {
        $uri = Route::getFacadeRoot()->current()->uri();

        $data = DB::table('ALL_USER_INFO')
            ->select('USER_ID', 'EMPLOYEE_ID', 'USER_GROUP_ID', 'INITIAL_PASSWORD', 'COMPANY_ID', 'USER_MOBILE',
                DB::raw('"GET_EMP_NAME"(EMPLOYEE_ID) as EMPLOYEE_NAME'))
            ->where('EMPLOYEE_ID', '=', session('LoggedUser'))
            ->get();
        $leftmenu = DB::table('ALL_USER_GROUP_DETAILS')
            ->crossJoin('ALL_MENU_HIERARCHY')
            ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'TITLE', 'DESCRIPTION')
            ->where('ALL_USER_GROUP_DETAILS.ENABLED', '=', 'Y')
            ->where('ALL_MENU_HIERARCHY.CHILD_ID', '=', DB::raw('ALL_USER_GROUP_DETAILS.MENU_ITEM_ID'))
            ->get();
        $submenu = DB::table('ALL_USER_SUB_DETAILS')
            ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'SUB_MENU_ID', 'SUB_MENU_1', 'SUB_MENU_2', 'SUB_MENU_NAME', 'ROUTE')
            ->whereNull('SUB_MENU_2')

            ->get();
        $headeer = DB::table('ALL_USER_SUB_DETAILS')
            ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'SUB_MENU_ID', 'SUB_MENU_1', 'SUB_MENU_2', 'SUB_MENU_NAME', 'ROUTE')
            ->where('ROUTE', '=', $uri)
            ->get();
        $empnoList = DB::table('EMP_PERSONAL')
            ->select('EMPNO')
            ->where('status', '=', 'Active')
            ->orderBy('EMPNO', 'asc')

            ->get();
        $submenu2 = DB::table('ALL_USER_SUB_DETAILS')
            ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'SUB_MENU_ID', 'SUB_MENU_1', 'SUB_MENU_2', 'SUB_MENU_NAME', 'ROUTE')
            ->whereNotNull('SUB_MENU_2')
            ->get();

        $designation = DB::table('DESIGNATION_DETAILS')
            ->select('DES_ID', 'DESIGNATION_NAME', 'IN_SHORT', 'GRADE_ID', 'IN_BENGALI', 'BNS_AMNT', 'NIGHT_BILL')
            ->get();
//return json_encode($deptList);
//        dd($ll)
        return view('hrm.increment', ['data' => $data, 'menu' => $leftmenu, 'submenu' => $submenu, 'headeer' => $headeer, 'submenu2' => $submenu2, 'empnoList' => $empnoList, 'designation' => $designation]);

    }
    public function getAllEmpList()
    {
        $uri = Route::getFacadeRoot()->current()->uri();

        if (!session('LoggedUser') == null) {try
            {
                $yaerList = DB::table('DUAL')
                    ->select(DB::raw('TO_CHAR(SYSDATE,\'YYYY\')-LEVEL+1 YEAR'))
                    ->whereRaw('TO_CHAR(SYSDATE,\'YYYY\')-LEVEL+1 > \'1985\'CONNECT BY LEVEL <=80')
                    ->get();
                $companyList = DB::table('COMPANY_PROFILE')
                    ->select('COMPANY_ID', 'COMPANY_NAME')
                    ->orderBy('COMPANY_ID', 'desc')
                    ->get();
                $deptList = DB::table('DEPT')
                    ->orderBy('DEPT_NO', 'asc')
                //  ->pluck('dept_no','dept_name');
                    ->get();
                $floorList = DB::table('FLOOR')
                    ->orderBy('Floor_id', 'asc')
                //  ->pluck('dept_no','dept_name');
                    ->get();

                $LineInfo = DB::table('LINE_INFO')
                    ->orderBy('LINE', 'asc')
                //  ->pluck('dept_no','dept_name');
                    ->get();

                $submenu2 = DB::table('ALL_USER_SUB_DETAILS')
                    ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'SUB_MENU_ID', 'SUB_MENU_1', 'SUB_MENU_2', 'SUB_MENU_NAME', 'ROUTE')
                    ->whereNotNull('SUB_MENU_2')
                    ->get();
                $sectionList = DB::table('SECTION')
                    ->orderBy('SECTION_NO', 'asc')
                    ->get();
                $religion = DB::table('RELIGION')
                    ->select('RELIGION_NAME', 'RELIGION_ID')
                    ->orderBy('RELIGION_ID', 'asc')
                    ->get();
                $data = DB::table('ALL_USER_INFO')
                    ->select('USER_ID', 'EMPLOYEE_ID', 'USER_GROUP_ID', 'INITIAL_PASSWORD', 'COMPANY_ID', 'USER_MOBILE',
                        DB::raw('"GET_EMP_NAME"(EMPLOYEE_ID) as EMPLOYEE_NAME'))
                    ->where('EMPLOYEE_ID', '=', session('LoggedUser'))
                    ->get();
                $leftmenu = DB::table('ALL_USER_GROUP_DETAILS')
                    ->crossJoin('ALL_MENU_HIERARCHY')
                    ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'TITLE', 'DESCRIPTION')
                    ->where('ALL_USER_GROUP_DETAILS.ENABLED', '=', 'Y')
                    ->where('ALL_MENU_HIERARCHY.CHILD_ID', '=', DB::raw('ALL_USER_GROUP_DETAILS.MENU_ITEM_ID'))
                    ->get();
                $submenu = DB::table('ALL_USER_SUB_DETAILS')
                    ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'SUB_MENU_ID', 'SUB_MENU_1', 'SUB_MENU_2', 'SUB_MENU_NAME', 'ROUTE')
                    ->whereNull('SUB_MENU_2')

                    ->get();
                $headeer = DB::table('ALL_USER_SUB_DETAILS')
                    ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'SUB_MENU_ID', 'SUB_MENU_1', 'SUB_MENU_2', 'SUB_MENU_NAME', 'ROUTE')
                    ->where('ROUTE', '=', $uri)
                    ->get();
                $empList = DB::table('EMP_PERSONAL')
                    ->crossJoin('EMP_OFFICIAL')
                    ->select(DB::raw('GET_COMPANY(EMP_PERSONAL.COMPANY_ID) as COMPANY_NAME'), 'EMP_PERSONAL.EMPNO', 'EMP_PERSONAL.NEW_EMPNO',
                     DB::raw('EMP_PERSONAL.FIRST_NAME||\' \'||EMP_PERSONAL.MIDDLE_NAME||\' \'||EMP_PERSONAL.LAST_NAME EMPNAME'), 'EMP_PERSONAL.FATHER_NAME', 
                     'EMP_PERSONAL.MOTHER_NAME', 'EMP_PERSONAL.RELIGION_NAME',
                     'EMP_PERSONAL.SEX', 'EMP_OFFICIAL.JOINING_DATE', 'EMP_PERSONAL.EMP_MOBILE_NO', 'EMP_OFFICIAL.AC_NO')
                    ->where('EMP_PERSONAL.EMPNO', '=', DB::raw('EMP_OFFICIAL.EMPNO'))
                    // ->where('EMP_PERSONAL.STATUS', '=', 'Active')
                    ->get();
                return view('hrm.emplist', ['data' => $data, 'menu' => $leftmenu, 'submenu' => $submenu, 'submenu2' => $submenu2, 'headeer' => $headeer, 'empList' => $empList]);
            } catch (Exception $e) {

            }

        }
    }
    public function tableData($empId)
    {
        $getTable = DB::table('INCREMENT_INFO')
            ->select('EMPNO', 'PREV_DESIGNATION', 'CUR_DESIGNATION', 'PREV_OT_ENT', 'CUR_OT_ENT', 'PREV_GROSS', 'INCR_TYPE', 'INCREMENT_AMT', 'CUR_GROSS', 'INCR_DATE', 'REMARK_TEXT', 'PREV_HOUSE_RENT', 'PREV_MEDICAL', 'PREV_BASIC', 'CUR_HOUSE_RENT', 'CUR_MEDICAL', 'CUR_BASIC', 'EFFECTIVE_DATE')
            ->where('EMPNO', '=', $empId)
            ->get();

        return view('hrm.incr_table', ['tableList' => $getTable]);
    }

    public function getEmpDet(Request $request)
    {
        $data = $request->input();

        $empDetails = DB::table('hrm.emp_increment_vw')
            ->select('NEW_EMPNO', 'EMPNO', 'EMP_NAME', DB::raw('TO_CHAR(JOINING_DATE,\'YYYY-MM-DD\') JOINING_DATE'), 'DEPT_NAME', 'SECTION_NAME', 'DES_NAME', DB::raw('TO_CHAR(LAST_INCREMENT_DATE,\'YYYY-MM-DD\') LAST_INCREMENT_DATE'))
            ->where('EMPNO', '=', $data['empno'])
            ->orderBy('NEW_EMPNO', 'ASC')
            ->get();
        return response()->json($empDetails);

    }

    public function getPrevGross(Request $request)
    {
        $data = $request->input();

        $getPrevGross = DB::table('EMP_PERSONAL')
            ->select(DB::raw('EMP_PERSONAL.first_name || \' \' ||  EMP_PERSONAL.middle_name || \' \' ||EMP_PERSONAL.last_name emp_name'), 'EMP_OFFICIAL.section_name', 'EMP_OFFICIAL.des_name', 'EMP_OFFICIAL.ot_ent', 'EMP_OFFICIAL.gross', 'emp_payment.basic', 'emp_payment.hr_amt', 'emp_payment.mr_amt')
            ->crossJoin('EMP_OFFICIAL')
            ->crossJoin('hrm.emp_payment')
            ->where(function ($query) {$query->whereRaw('EMP_OFFICIAL.EMPNO = EMP_PERSONAL.EMPNO');})
            ->where(function ($query) {$query->whereRaw('EMP_PERSONAL.EMPNO = emp_payment.EMPNO');})
            ->where('emp_personal.status', '=', 'Active')
            ->where('EMP_PERSONAL.empno', '=',  $data['empno'])
            ->get();
        return response()->json($getPrevGross);

    }

    public function empaddressSave(Request $request)
    {

        $data = $request->input();
      

        if (!session('LoggedUser') == null) {

            $empPersonal = Emp_locationModel::where('empno', '=', $data['empadempno'])->get();
            $empno = count($empPersonal);
            // return response()->json([
            //     $data,
            // ]);

            if ($empno > 0) {

                $empaddressdata = $request->input();
try{


    $empLoc = Emp_locationModel::where('empno', '=', $data['empadempno'])->update([
        //  'empno '-> $empaddressdata['empadempno'],
           'p_address'=> $empaddressdata['p_address'],
          'p_city'=> $empaddressdata['p_city'],
        'p_district'=> $empaddressdata['p_district2'],
          'p_phone'=> $empaddressdata['p_phone'],
          'p_fax'=> $empaddressdata['p_fax'],
          'p_cperson'=> $empaddressdata['p_cperson'],
          'r_address'=> $empaddressdata['r_address'],
          'r_city'=> $empaddressdata['r_city'],
          'r_district'=> $empaddressdata['r_district'],
        //   'r_pin_cod'=>$empaddressdata['r_pin_cod'],
          'r_phone'=> $empaddressdata['r_phone'],
          'r_fax'=> $empaddressdata['r_fax'],
          'r_mobile'=> $empaddressdata['r_mobile'],
          'r_email'=> $empaddressdata['r_email'],
          'r_cperson'=> $empaddressdata['r_cperson'],
          'p_village'=> $empaddressdata['p_village'],
          'p_post_off'=> $empaddressdata['p_post_office'],
          'p_police_station'=> $empaddressdata['p_police_station11'],
          
      ]);
      return response()->json([
          'status' => 200,
      ]);

}catch (\Illuminate\Database\QueryException $e) {
    //  dd($e);
      return response()->json([
          $e->getCode(),
      ]);
    }

            }else{


            $empaddressdata = $request->input();
            $empadress = new Emp_locationModel;
            $empadress->empno = $empaddressdata['empadempno'];
            $empadress->p_address = $empaddressdata['p_address'];
            $empadress->p_city = $empaddressdata['p_city'];
            $empadress->p_district = $empaddressdata['p_district2'];
            $empadress->p_pin_code = $empaddressdata['p_pin_code'];
            $empadress->p_phone = $empaddressdata['p_phone'];
            $empadress->p_fax = $empaddressdata['p_fax'];
            $empadress->p_cperson = $empaddressdata['p_cperson'];
            $empadress->r_address = $empaddressdata['r_address'];
            $empadress->r_city = $empaddressdata['r_city'];
            $empadress->r_district = $empaddressdata['r_district'];
                //$empadress->r_pin_cod=$empaddressdata['r_pin_cod'];
            $empadress->r_phone = $empaddressdata['r_phone'];
            $empadress->r_fax = $empaddressdata['r_fax'];
            $empadress->r_mobile = $empaddressdata['r_mobile'];
            $empadress->r_email = $empaddressdata['r_email'];
            $empadress->r_cperson = $empaddressdata['r_cperson'];
            $empadress->p_village = $empaddressdata['p_village'];
            $empadress->p_post_off = $empaddressdata['p_post_office'];
            $empadress->p_police_station = $empaddressdata['p_police_station11'];
            $empadress->save();
            return response()->json([
                'status' => 200,
            ]);

        }
        } else {
            return redirect('login');

        }

    }

    public function empeduSave(Request $request)
    {
        if (!session('LoggedUser') == null) {
            $empedudata = $request->input();
            $empedu = new Emp_qualificationModel;
            $empedu->empno = $empedudata['empnoedu'];
            $empedu->name_of_ins = $empedudata['name_of_ins'];
//$empedu->passed_exam=$empedudata['passed_exam'];
            $empedu->division = $empedudata['division'];
            $empedu->year = $empedudata['year'];
            $empedu->board = $empedudata['board'];
            $empedu->marks = $empedudata['marks'];
            $empedu->subject = $empedudata['subject'];
            $empedu->save();

            return response()->json([
                'status' => 200,
            ]);
        } else {
            return redirect('login');

        }

    }

    public function empShortSave(Request $request)
    {
        if (!session('LoggedUser') == null) {

            $empshortCourse = $request->input();
            $empshor = new Emp_ShortModel;
            $empshor->empno = $empshortCourse['empnoshtcourse'];
            $empshor->course_name = $empshortCourse['course_name'];
            $empshor->conducted_by = $empshortCourse['conducted_by'];
            $empshor->c_from = $empshortCourse['c_from'];
            // $empshor->c_to=$empshortCourse['total_day'];
            $empshor->certificate = $empshortCourse['certificate'];
            $empshor->total_day = $empshortCourse['total_day'];
            $empshor->save();

            return response()->json([
                'status' => 200,
            ]);
        } else {
            return redirect('login');

        }

    }

    public function empNomineeSave(Request $request)
    {
        $empNominee = $request->input();
        //return $empNominee ;

        if (!session('LoggedUser') == null) {

            $findEMp=Emp_familyModel::where('EMPNO', '=', $empNominee['empnoNominee'])->get();
            $empno = count($findEMp);

            if($empno>0){
                return response()->json([
                    'status' => 400,
                ]);
            }else{


            $empFami = new Emp_familyModel;
            $empFami->empno = $empNominee['empnoNominee'];
            $empFami->depd_name = $empNominee['depd_name'];
            $empFami->depent_name_bangla = $empNominee['depent_name_bangla'];
            $empFami->relationship = $empNominee['relationship'];
            $empFami->d_age = $empNominee['d_age'];
            $empFami->d_sex = $empNominee['d_sex'];
            $empFami->percentage = $empNominee['percentage'];
            $empFami->relation_bn = $empNominee['relation_bn'];
            $empFami->address = $empNominee['address'];
            $empFami->address_bn = $empNominee['address_bn'];
            $empFami->save();
            return response()->json([
                'status' => 200,
            ]);
        }
        } else {
            return redirect('login');

        }

    }

    public function empHistory(Request $request)
    {
        if (!session('LoggedUser') == null) {

            $empHisto = $request->input();
            $empJob = new Emp_historyModel;
            $empJob->empno = $empHisto['empnojob'];
            $empJob->join_as = $empHisto['join_as'];
            $empJob->designation = $empHisto['designation'];
            $empJob->work_location = $empHisto['work_location'];
            $empJob->join_date = $empHisto['join_date'];

            $empJob->save();
            return response()->json([
                'status' => 200,
            ]);
        } else {
            return redirect('login');

        }

    }

    public function empTraining(Request $request)
    {
        if (!session('LoggedUser') == null) {

            $empTraining = $request->input();
            $empTrain = new Emp_trainingModel;
            $empTrain->empno = $empTraining['empnotraining'];
            $empTrain->t_title = $empTraining['t_title'];
            $empTrain->t_conducted_by = $empTraining['t_conducted_by'];
            $empTrain->t_from = $empTraining['t_from'];
            $empTrain->t_to = $empTraining['t_to'];
            $empTrain->t_certificate = $empTraining['t_certificate'];
            $empTrain->skill_type = $empTraining['skill_type'];
            $empTrain->to_days = $empTraining['to_days'];

            $empTrain->save();
            return response()->json([
                'status' => 200,
            ]);
        } else {
            return redirect('login');

        }

    }
    public function empExp(Request $request)
    {
        if (!session('LoggedUser') == null) {

            $empExperience = $request->input();
            $empExpe = new Emp_work_expModel;
            $empExpe->empno = $empExperience['empnoexp'];
            $empExpe->organization = $empExperience['organization'];
            $empExpe->d_from = $empExperience['d_from'];
            $empExpe->d_to = $empExperience['d_to'];
            //$empExpe->t_to=$empExperience['total_years'];
            $empExpe->leave_reason = $empExperience['leave_reason'];
            $empExpe->prv_emp_no = $empExperience['prv_emp_no'];
            $empExpe->org_address = $empExperience['org_address'];
            $empExpe->org_tel = $empExperience['org_tel'];
            $empExpe->last_sal_drawn = $empExperience['last_sal_drawn'];
            $empExpe->total_days = $empExperience['total_years'];
            $empExpe->designation = $empExperience['designation'];

            $empExpe->save();
            return response()->json([
                'status' => 200,
            ]);
        } else {
            return redirect('login');

        }

    }

    public function increment_Entry(Request $request)
    {
        $data = $request->input();
        $inDt = new IncrementDetailsModel;
        $inDt->empno = $data['empno'];
        // $inDt->section=$data[''];
        $inDt->prev_designation = $data['prev_designation'];
        $inDt->emp_name = $data['empname'];
        $inDt->prev_gross = $data['prev_gross'];
        $inDt->prev_house_rent = $data['prev_house_rent'];
        $inDt->prev_medical = $data['prev_medical'];
        $inDt->increment_amt = $data['increment_amt'];
        $inDt->cur_gross = $data['cur_gross'];
        $inDt->cur_designation = $data['cur_designation'];
        $inDt->cur_ot_ent = $data['cur_ot_ent'];
        $inDt->prev_ot_ent = $data['prev_ot_ent'];
        // $inDt->curr_grade=$data[''];
        $inDt->remark_text = $data['remark_text'];
        $inDt->effective_date = $data['effective_date'];
        $inDt->incr_type = $data['incr_type'];
        $inDt->incr_date = $data['incr_date'];
        $inDt->cur_basic = $data['cur_basic'];
        $inDt->prev_basic = $data['prev_basic'];
        $inDt->cur_house_rent = $data['cur_house_rent'];
        $inDt->cur_medical = $data['cur_medical'];
        $inDt->save();
        return response()->json([
            'status' => 200,
        ]);
    }




    public function leaveentry(){


        $uri = Route::getFacadeRoot()->current()->uri();

        $data = DB::table('ALL_USER_INFO')
            ->select('USER_ID', 'EMPLOYEE_ID', 'USER_GROUP_ID', 'INITIAL_PASSWORD', 'COMPANY_ID', 'USER_MOBILE',
                DB::raw('"GET_EMP_NAME"(EMPLOYEE_ID) as EMPLOYEE_NAME'))
            ->where('EMPLOYEE_ID', '=', session('LoggedUser'))
            ->get();
        $leftmenu = DB::table('ALL_USER_GROUP_DETAILS')
            ->crossJoin('ALL_MENU_HIERARCHY')
            ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'TITLE', 'DESCRIPTION')
            ->where('ALL_USER_GROUP_DETAILS.ENABLED', '=', 'Y')
            ->where('ALL_MENU_HIERARCHY.CHILD_ID', '=', DB::raw('ALL_USER_GROUP_DETAILS.MENU_ITEM_ID'))
            ->get();
        $submenu = DB::table('ALL_USER_SUB_DETAILS')
            ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'SUB_MENU_ID', 'SUB_MENU_1', 'SUB_MENU_2', 'SUB_MENU_NAME', 'ROUTE')
            ->whereNull('SUB_MENU_2')

            ->get();
        $headeer = DB::table('ALL_USER_SUB_DETAILS')
            ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'SUB_MENU_ID', 'SUB_MENU_1', 'SUB_MENU_2', 'SUB_MENU_NAME', 'ROUTE')
            ->where('ROUTE', '=', $uri)
            ->get();
        $empnoList = DB::table('EMP_PERSONAL')
            ->select('EMPNO')
            ->where('status', '=', 'Active')
            ->orderBy('EMPNO', 'asc')

            ->get();
        $submenu2 = DB::table('ALL_USER_SUB_DETAILS')
            ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'SUB_MENU_ID', 'SUB_MENU_1', 'SUB_MENU_2', 'SUB_MENU_NAME', 'ROUTE')
            ->whereNotNull('SUB_MENU_2')
            ->get();
        //return json_encode($deptList);
        //        dd($ll)
$leaveCatt=DB::table('HRM.LEAVE_INFO')
->select('LEAVE_NAME','LEAVE_ID')
->get();

$yaerList = DB::table('DUAL')
                    ->select(DB::raw('TO_CHAR(SYSDATE,\'YYYY\')-LEVEL+1 YEAR'))
                    ->whereRaw('TO_CHAR(SYSDATE,\'YYYY\')-LEVEL+1 > \'1985\'CONNECT BY LEVEL <=80')
                    ->get();
                $companyList = DB::table('COMPANY_PROFILE')
                    ->select('COMPANY_ID', 'COMPANY_NAME')
                    ->orderBy('COMPANY_ID', 'desc')
                    ->get();

        return view('hrm.leaveentry', ['companyList'=>$companyList,'yaerList'=>$yaerList,'leaveCatt'=>$leaveCatt, 'data' => $data,  'menu' => $leftmenu, 'submenu' => $submenu, 'headeer' => $headeer, 'submenu2' => $submenu2, 'empnoList' => $empnoList]);

    }

    public function getLeaveDetails($empno,$year){
        $getLeaveDetails=DB::table('LEAVE_ENTRY_DETAILS')
        ->where('YEAR','=',$year)
        ->where('EMPNO','=',$empno)
        ->get();
        return view('hrm.leave_table',[
           'getLeaveDetails'=> $getLeaveDetails,
        ]);
    }

    public function getLeavePrebal($empno,$year,$lv){
        $getLPrebal= DB::table(DB::raw('LEAVE_ENTRY_DETAILS LV'))
        ->select(DB::raw('NVL(SUM(APPROVE_DAYS),0) APPROVE_DAYS'))
        ->where('LV.leave_id','=',$lv)
        ->where('empno', '=', $empno)
        ->whereRaw('\''.$year.'\' = to_char(lv_to,\'YYYY\')')
        ->whereRaw('\''.$year.'\' = to_char(lv_from,\'YYYY\')')
        ->get();

       
        return $getLPrebal ;

    }

    public function getLeavBal($lv){
    

        $getLeaveMax=DB::table('leave_info')
        ->select(DB::raw('nvl(max_days,60)max_days'))
        ->where('leave_id','=',$lv)
        ->get();
        return $getLeaveMax ;

    }

    public function leaveEntryIns(Request $request){

        $data = $request->input();
        $leaveCount=DB::table('LEAVE_ENTRY_MASTER')
        ->selectRaw('COUNT(*) AS COUNT_LEAVE')
        ->where('YEAR','=',$data['year'])
        ->where('EMPNO','=', $data['empno'])
        ->where('COMPANY_ID','=',$data['company_id'])
        ->first();
       // $count = count($leaveCount);
      //  dd($leaveCount);
if (optional($leaveCount)->count_leave>0){
    return response()->json([
        'status' => 200,
    ]);
}else{
    try{
        $leave = new LeaveEntryMaster;
        $leave->company_id = $data['company_id'];
        $leave->empno = $data['empno'];
        $leave->lv_cat_id = $data['lv_cat_id'];
        $leave->new_empno = $data['empno'];
        $leave->year = $data['year'];
        $leave->save();
        return response()->json([
            'status' => 200,
        ]);
    }catch(\Illuminate\Database\QueryException $e){
        return $e;

    } 

}

    }

    public function leaveEntryDet(Request $request){
        $data = $request->input();
        //dd($data);
        $maxSl=DB::table('LEAVE_ENTRY_details')
        ->select(DB::raw('(nVL(MAX(LV_SL),0)+1) lv_sl'))
        ->where('YEAR','=',$data['year_det'])
        ->where('EMPNO','=',$data['emp_no_det'])
        ->where('lv_cat_id','=',$data['lv_cat_id_det'])
        ->first();
        $max=$maxSl->lv_sl;
        //dd($max);
        try{
            $leave = new LeaveEntryDetails;
            $leave->lv_cat_id = $data['lv_cat_id_det'];
            $leave->year = $data['year_det'];
            $leave->empno = $data['emp_no_det'];
           // $leave->leave_name = $data['leave_name'];
            $leave->balance = $data['new_balance'];
           // $leave->application_no = $data['empno'];
            $leave->application_date = $data['submitted'];
            $leave->approve_date = $data['approve_date'];
            $leave->approve_days = $data['approve_days'];
            $leave->approve_by = $data['approve_by'];
            $leave->lv_from = $data['lv_from'];
            $leave->lv_to = $data['lv_to'];
            $leave->leave_id = $data['leave_name'];
            $leave->max_days = $data['max_days'];
            $leave->pre_balance = $data['pre_balance'];
            $leave->remax = $data['remarks'];
            $leave->information = $data['information'];
            $leave->lv_sl = $max;
            $leave->save();
            return response()->json([
                'status' => 200,
            ]);
        }catch(\Illuminate\Database\QueryException $e){
            return $e;
    
        } 
        

    }



    public function empSearchExist(Request $request){
        $data = $request->input();
        $empcount=DB::table('EMP_PERSONAL')
        ->select(DB::raw("COUNT(EMPNO) as EMPCOUNT"))
        ->where('EMPNO','=',$data ['empno'])
        ->get();
      
        return $empcount;

    }


    public function deleteLeave($empno,$year,$sl){





        $destryfind =   $maxSl=DB::table('LEAVE_ENTRY_details')
        ->select('lv_sl')
        ->where('YEAR','=',$year)
        ->where('EMPNO','=',$empno)
        ->where('lv_sl','=',$sl)
        ->first();
      //  dd($destryfind);
        //$countCom=count($destryfind);
       // dd($countCom);
    if (!optional($destryfind)->lv_sl == null) {
     //   dd($destryfind->company_id);
        try {
            $destroy = DB::table('LEAVE_ENTRY_details')
            ->where('YEAR','=',$year)
            ->where('EMPNO','=',$empno)
            ->where('lv_sl','=',$sl)                
            ->delete();

                return response()->json([
                    'status2' => 200,
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
          //  dd($e);
            return response()->json([
                $e->getCode(),
            ]);

        }
    }

    }




}