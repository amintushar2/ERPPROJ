<?php

namespace App\Http\Controllers;

use App\Models\EmpOfficial;
use App\Models\EmpPersonal;
use App\Models\Emp_familyModel;
use App\Models\Emp_historyModel;
use App\Models\Emp_locationModel;
use App\Models\EmpLocation;


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

    public function employeePersonalInsert(Request $request)
    {
        $data = $request->input();
        $request->validate([
            'empno' => 'required',
            'company_id' => 'required',

        ]);
        return $data['dob'];
        $empPersonal = EmpPersonal::where('NEW_EMPNO', '=', $data['empno'])->get();
        $empno = count($empPersonal);
        // return response()->json([
        //     'status2' => 200, $empno
        // ]);

        if (!session('LoggedUser') == null) {
          //  return $data;
            if ($empno > 0) {
                $data = $request->input();
                $imageName=DB::table('EMP_PERSONAL')
                ->select('EMP_IMG')
                ->where('EMPNO','=',$data['empno'])
                ->first();

               // return  [$imageName];

                $signatur=DB::table('EMP_PERSONAL')
                ->select('EMP_SIGN')
                ->where('EMPNO','=',$data['empno'])
                ->first();
                $religionName = DB::table('RELIGION')
                    ->select('RELIGION_NAME', 'RELIGION_ID')
                    ->WHERE('RELIGION_ID', '=', $data['religion_id'])
                    ->first();
                  

                    if($request->file('photo')==null){
                   
                    $imagename =  $imageName->emp_img;
                    }else{
                        if(Storage::disk('ftp2')->exists('emp_photo/'.$imageName->emp_img)){
                            Storage::disk('ftp2')->delete('emp_photo/'.$imageName->emp_img);
                        
                        
                            $imagename = $data['empno'] . '.' . $request->file('photo')->getClientOriginalExtension();
                            // $request->file('photo')->storeAs('emp_image', $imagename);
                             Storage::disk('ftp2')->put('emp_photo/'.$imagename, fopen(  $request->file('photo'), 'r+'));
                        
                        }
           
                    }
                    if($request->file('signature')==null){
                    
                      $signaturename =$signatur->emp_sign;
                    }else{

                        if(Storage::disk('ftp2')->exists('emp_sign/'.$signatur->emp_sign)){
                            Storage::disk('ftp2')->delete('emp_sign/'.$signatur->emp_sign);
                            $signaturename = $data['empno'] . '.' . $request->file('signature')->getClientOriginalExtension();
                            // $request->file('signature')->storeAs('emp_sign', $signaturename);
                            Storage::disk('ftp2')->put('emp_sign/'.$signaturename, fopen($request->file('signature'), 'r+'));                        
                        }
                
                    }
              




                $empPersonal = EmpPersonal::where('NEW_EMPNO', '=', $data['empno']);
                $empPersonal->update([

                  //  'empno' => $data['empno'],
                    'card_no' => $data['card_no'],
                    'first_name' => $data['first_name'],
                    'middle_name' => $data['middle_name'],
                    'last_name' => $data['last_name'],
                    'b_name' => $data['b_name'],
                    'dob' => $data['dob'],
                    // 'age' => $data['age'],
                    'sex' => $data['sex'],
                    'marial_status'=>$data['marial_status'],
                    'id_mark' => $data['id_mark'],
                    'blood_group' => $data['blood_group'],
                    'passport_no' => $data['passport_no'],
                    'place_of_issue' => $data['place_of_issue'],
                    'valid_till' => $data['valid_till'],
                    'religion_name' => $religionName->religion_name,
                    'nationality_desc' => $data['nationality_desc'],
                    'status' => $data['status'],
                    'father_name' => $data['father_name'],
                    'mother_name' => $data['mother_name'],
                    'husband_name' => $data['husband_name'],
                    'as_on' => $data['as_on'],
                    'age2' => $data['ageDet'],
                    'hbs_test' => $data['hbs_test'],
                    'emp_mobile_no' => $data['emp_mobile_no'],
                    // 'is_report'=> $data['national_id_no'],
                   'id_card_issue' => $data['id_card_issue'],
               'company_id' => $data['company_id'],
                 'sms_mobile_no' => $data['sms_mobile_no'],
                'new_empno' => $data['empno'],
                   'birthday_id' => $data['birthday_id'],
               'last_education' => $data['last_education'],
                  // 'insert_by' => session('LoggedUser'),
                'update_user' => Str::upper(session('LoggedId')),
              'office_food'=>$data['office_food'],
                    'religion_id' => $data['religion_id'],
                    'emp_img' => $imagename,
                    'emp_sign' => $signaturename,
                ]);
                return response()->json([
                    'status' => 200,
                ]);
            } else {

                $data = $request->input();
                $religionName = DB::table('RELIGION')
                    ->select('RELIGION_NAME', 'RELIGION_ID')
                    ->WHERE('RELIGION_ID', '=', $data['religion_id'])

                    ->first();




                    if($request->file('photo')==null){
                        $imagename = '';
                    }else{
                        $imagename = $data['empno'] . '.' . $request->file('photo')->getClientOriginalExtension();
                        // $request->file('photo')->storeAs('emp_image', $imagename);
                         Storage::disk('ftp2')->put('emp_photo/'.$filenametostore, fopen(  $request->file('photo'), 'r+'));

                    }
                    if($request->file('photo')==null){
                        $signaturename = '';
                    }else{
                        $signaturename = $data['empno'] . '.' . $request->file('signature')->getClientOriginalExtension();
                        // $request->file('signature')->storeAs('emp_sign', $signaturename);
                        Storage::disk('ftp2')->put('emp_sign/'.$filenametostore, fopen($request->file('signature'), 'r+'));

                    }


                try {

                    $employeePersonal = new EmpPersonal;
                    $employeePersonal->empno = $data['empno'];
                    $employeePersonal->card_no = $data['card_no'];
                    $employeePersonal->first_name = $data['first_name'];
                    $employeePersonal->middle_name = $data['middle_name'];
                    $employeePersonal->last_name = $data['last_name'];
                    $employeePersonal->b_name = $data['b_name'];

                    $employeePersonal->dob = $data['dob'];
                    $employeePersonal->age2 = $data['ageDet'];
                    $employeePersonal->sex = $data['sex'];
                    //  $employeePersonal->marial_status=$data['marial_status'];
                    $employeePersonal->id_mark = $data['id_mark'];
                    $employeePersonal->blood_group = $data['blood_group'];
                    $employeePersonal->passport_no = $data['passport_no'];
                    $employeePersonal->place_of_issue = $data['place_of_issue'];
                    $employeePersonal->valid_till = $data['valid_till'];
                    $employeePersonal->religion_name = $religionName->religion_name;
                    $employeePersonal->nationality_desc = $data['nationality_desc'];
                    $employeePersonal->status = $data['status'];
                    $employeePersonal->father_name = $data['father_name'];
                    $employeePersonal->mother_name = $data['mother_name'];
                    $employeePersonal->husband_name = $data['husband_name'];
                    $employeePersonal->as_on = $data['as_on'];
                    // $employeePersonal->age2 = $data['age'];
                    $employeePersonal->hbs_test = $data['hbs_test'];
                    $employeePersonal->emp_mobile_no = $data['emp_mobile_no'];
                    $employeePersonal->national_id_no = $data['national_id_no'];
                    $employeePersonal->id_card_issue = $data['id_card_issue'];
                    $employeePersonal->company_id = $data['company_id'];
                    $employeePersonal->sms_mobile_no = $data['sms_mobile_no'];
                    $employeePersonal->new_empno = $data['empno'];
                    $employeePersonal->birthday_id = $data['birthday_id'];
                    $employeePersonal->last_education = $data['last_education'];
                    $employeePersonal->insert_by = Str::upper(session('LoggedUser'));
                    $employeePersonal->update_user = Str::upper(session('LoggedUser'));
                    $employeePersonal->office_food=$data['office_food'];
                    $employeePersonal->religion_id = $data['religion_id'];
                    $employeePersonal->emp_img = $imagename;
                    $employeePersonal->emp_sign = $signaturename;
                    $employeePersonal->save();
                    return response()->json([
                        'status' => 200,
                    ]);

                } catch (Exception $e) {

                }
            }
        }

    }

    public function employeeOfficialInsert(Request $request)
    {

        $data = $request->input();
       // return $data;

        // $request->validate([
        //     'empno' => 'required',
        //     'company_id' => 'required',

        // ]);

        
        $companuProf=DB::table('COMPANY')
        ->select('COMPANY_NAME')
        ->where('COMPANY_ID','=',$data['company_id'])
        ->first();
        $deptName=DB::table('DEPT')
        ->select('DEPT_NAME')
        ->where('DEPT_NO','=',$data['dept_no'])
        ->first();
        $sectionName=DB::table('SECTION')
        ->select('SECTION_NAME')
        ->where('SECTION_NO','=',$data['section_no'])
        ->first();
        $gradeName=DB::table('GRADE')
        ->select('GRADE_ID', 'GRADE_NAME')
        ->where('GRADE_ID','=',$data['grade_id'])
        ->first();
        $lineName=DB::table('LINE_INFO')
        ->select('LINE', 'LINE_NO')
        ->where('LINE_NO','=',$data['line'])
        ->first();
        $desName=DB::table('DESIGNATION_DETAILS')
        ->select('DESIGNATION_NAME')
        ->where('DES_ID','=',$data['des_id'])
        ->first();


        if (!session('LoggedUser') == null) {
            $empOffc = EmpOfficial::where('empno', '=', $data['empof_id'])->get();
            $empno = count($empOffc);
          

            if ($empno > 0) {
                $officialdata = $request->input();
                

                $empOff = EmpOfficial::where('empno', '=', $data['empof_id']);

                $empOff->update([
                    'empno' => $officialdata['empof_id'],
                    'company_id' => $officialdata['company_id'],
                     'company_name'=>$companuProf->company_name?? '',
                    'dept_no' => $officialdata['dept_no'],
                 'dept_name'=>$deptName->dept_name,
                    'section_no' => $officialdata['section_no'],
                    'section_name'=>$sectionName->section_name?? '',
                    'emp_type' => $officialdata['emp_type'],
                    'grade_id' => $officialdata['grade_id'],
                     'grade_name'=>$gradeName->grade_name?? '',
                    'joining_date' => $officialdata['joining_date'],
                    'work_ent' => $officialdata['work_ent'],
                    'ot_ent' => $officialdata['ot_ent'],
                    'tran_ent' => $officialdata['tran_ent'],
                        // 'pes_ent'=>$officialdata['pes_ent'],
                    'tax_ent' => $officialdata['tax_ent'],
                    'pf_ent' => $officialdata['pf_ent'],
                    'termination_date' => $officialdata['termination_date'],
                    'resigned_date' => $officialdata['resigned_date'],
                    'weekly_off' => $officialdata['weekly_off'],
                    'bank_name' => $officialdata['bank_name'],
                    'tin_no' => $officialdata['tin_no'],
                    'ac_no' => $officialdata['ac_no'],
                    'cal_code' => $officialdata['cal_code'],
                    'shift_code' => $officialdata['shift_code'],
                    // 's_group_name'=>$officialdata['s_group_name'],
                    'lv_cat_id' => $officialdata['lv_cat_id'],
                    'gross' => $officialdata['gross'],
                        // 'shift_name'=>$officialdata['shift_name'],
                    'des_id' => $officialdata['des_id'],
                    'des_name'=>$desName->designation_name,
                    'floor_id' => $officialdata['floor_id'],
                    'line' => $officialdata['line'],
                     'line_info'=>$lineName->line?? '',
                            // 'piece_rate'=>$officialdata['piece_rate'],
                    'pro_fund' => $officialdata['pro_fund'],
                        // 'shift_rostering'=>$officialdata['shift_rostering'],
                    'bank_ac_no' => $officialdata['bank_ac_no'],
                    'tax_deduction' => $officialdata['tax_deduction'],
                    'service_book_number' => $officialdata['service_book_number'],
                    'other_allowance' => $officialdata['other_allowance'],
                    'conform_date' => $officialdata['conform_date'],
                   
                    'update_user' => Str::upper(session('LoggedId')),
                    'res_ent' => $officialdata['res_ent'],
                    'is_lefty' => $officialdata['is_lefty'],
                ]);
                return response()->json([
                    'status' => 200,
                ]);
            } else {
                $officialdata = $request->input();
                $employeeOffical = new EmpOfficial();
                $employeeOffical->empno = $officialdata['empof_id'];
                $employeeOffical->company_id = $officialdata['company_id'];
                 $employeeOffical->company_name=$companuProf->company_name;
                $employeeOffical->dept_no = $officialdata['dept_no'];
                 $employeeOffical->dept_name=$deptName->dept_name;
                $employeeOffical->section_no = $officialdata['section_no'];
                 $employeeOffical->section_name=$sectionName->section_name;
                $employeeOffical->emp_type = $officialdata['emp_type'];
                $employeeOffical->grade_id = $officialdata['grade_id'];
                 $employeeOffical->grade_name=$gradeName->grade_name;
                $employeeOffical->joining_date = $officialdata['joining_date'];
                $employeeOffical->work_ent = $officialdata['work_ent'];
                $employeeOffical->ot_ent = $officialdata['ot_ent'];
                $employeeOffical->tran_ent = $officialdata['tran_ent'];
                // $employeeOffical->pes_ent=$officialdata['pes_ent'];
                $employeeOffical->tax_ent = $officialdata['tax_ent'];
                $employeeOffical->pf_ent = $officialdata['pf_ent'];
                $employeeOffical->termination_date = $officialdata['termination_date'];
                $employeeOffical->resigned_date = $officialdata['resigned_date'];
                $employeeOffical->weekly_off = $officialdata['weekly_off'];
                $employeeOffical->bank_name = $officialdata['bank_name'];
                $employeeOffical->tin_no = $officialdata['tin_no'];
                $employeeOffical->ac_no = $officialdata['ac_no'];
                $employeeOffical->cal_code = $officialdata['cal_code'];
                $employeeOffical->shift_code = $officialdata['shift_code'];
                // $employeeOffical->s_group_name=$officialdata['s_group_name'];
                $employeeOffical->lv_cat_id = $officialdata['lv_cat_id'];
                $employeeOffical->gross = $officialdata['gross'];
                // $employeeOffical->shift_name=$officialdata['shift_name'];
                $employeeOffical->des_id = $officialdata['des_id'];
                 $employeeOffical->des_name=$desName->designation_name;
                $employeeOffical->floor_id = $officialdata['floor_id'];
                $employeeOffical->line = $officialdata['line'];
                 $employeeOffical->line_info=$lineName->line;
                // $employeeOffical->piece_rate=$officialdata['piece_rate'];
                $employeeOffical->pro_fund = $officialdata['pro_fund'];
                // $employeeOffical->shift_rostering=$officialdata['shift_rostering'];
                $employeeOffical->bank_ac_no = $officialdata['bank_ac_no'];
                $employeeOffical->tax_deduction = $officialdata['tax_deduction'];
                $employeeOffical->service_book_number = $officialdata['service_book_number'];
                $employeeOffical->other_allowance = $officialdata['other_allowance'];
                $employeeOffical->conform_date = $officialdata['conform_date'];
                $employeeOffical->insert_by = Str::upper(session('LoggedId'));
          
                $employeeOffical->res_ent = $officialdata['res_ent'];
                $employeeOffical->is_lefty = $officialdata['is_lefty'];
                
                $employeeOffical->save();
                return response()->json([
                    'status' => 200,
                ]);
            }
        } else {
            return redirect('login');

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