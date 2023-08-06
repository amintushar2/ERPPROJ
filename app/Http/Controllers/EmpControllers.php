<?php

namespace App\Http\Controllers;
USE DB;
use Illuminate\Http\Request;
use Session;
use Carbon\Carbon;


use App\Models\EmpPersonal;
use App\Models\EmpOfficial;
use App\Models\Emp_locationModel;

use App\Models\Emp_qualificationModel;
use App\Models\Emp_ShortModel;
use App\Models\Emp_familyModel;
use App\Models\Emp_historyModel;
use App\Models\Emp_trainingModel;
use App\Models\Emp_work_expModel;
use App\Models\IncrementDetailsModel;




use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route ;

class EmpControllers extends Controller
{
    function empentry(Request $request){
$uri = Route::getFacadeRoot()->current()->uri();

        if(!session('LoggedUser')==null)
{        try
        {
            $yaerList=DB::table('DUAL')
            ->select(DB::raw('TO_CHAR(SYSDATE,\'YYYY\')-LEVEL+1 YEAR'))
            ->whereRaw('TO_CHAR(SYSDATE,\'YYYY\')-LEVEL+1 > \'1985\'CONNECT BY LEVEL <=80')
            ->get();
            $companyList=DB::table('COMPANY_PROFILE')
            ->select('COMPANY_ID','COMPANY_NAME')
            ->orderBy('COMPANY_ID','desc')
             ->get();
                    $deptList=DB::table('DEPT')
                    ->orderBy('DEPT_NO','asc')
                  //  ->pluck('dept_no','dept_name');
                    ->get();
                    $floorList=DB::table('FLOOR')
                    ->orderBy('Floor_id','asc')
                  //  ->pluck('dept_no','dept_name');
                    ->get();

                    $LineInfo=DB::table('LINE_INFO')
                    ->orderBy('LINE','asc')
                  //  ->pluck('dept_no','dept_name');
                    ->get();
$designation=DB::table('DESIGNATION_DETAILS')
->select('DES_ID', 'DESIGNATION_NAME', 'IN_SHORT', 'GRADE_ID', 'IN_BENGALI', 'BNS_AMNT', 'NIGHT_BILL')
->get();
          
            $sectionList=DB::table('SECTION')
            ->orderBy('SECTION_NO','asc')
            ->get();
            $religion=DB::table('RELIGION')
            ->select('RELIGION_NAME', 'RELIGION_ID')
            ->orderBy('RELIGION_ID','asc')
            ->get();
            $data =  DB::table('ALL_USER_INFO')
            ->select('USER_ID', 'EMPLOYEE_ID', 'USER_GROUP_ID', 'INITIAL_PASSWORD', 'COMPANY_ID', 'USER_MOBILE',
             DB::raw('"GET_EMP_NAME"(EMPLOYEE_ID) as EMPLOYEE_NAME'))
            ->where('EMPLOYEE_ID','=',session('LoggedUser'))
            ->get();
            $leftmenu =DB::table('ALL_USER_GROUP_DETAILS')
            ->crossJoin('ALL_MENU_HIERARCHY')
            ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'TITLE', 'DESCRIPTION')
            ->where('ALL_USER_GROUP_DETAILS.ENABLED','=','Y')
            ->where('ALL_MENU_HIERARCHY.CHILD_ID','=',DB::raw('ALL_USER_GROUP_DETAILS.MENU_ITEM_ID'))
            ->get();
            $submenu=DB::table('ALL_USER_SUB_DETAILS')
            ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'SUB_MENU_ID', 'SUB_MENU_1', 'SUB_MENU_2', 'SUB_MENU_NAME','ROUTE')
            ->whereNull('SUB_MENU_2')
            ->get();
            $submenu2=DB::table('ALL_USER_SUB_DETAILS')
            ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'SUB_MENU_ID', 'SUB_MENU_1', 'SUB_MENU_2', 'SUB_MENU_NAME','ROUTE')
            ->whereNotNull('SUB_MENU_2')
            ->get();
            $headeer =DB::table('ALL_USER_SUB_DETAILS')
            ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'SUB_MENU_ID', 'SUB_MENU_1', 'SUB_MENU_2', 'SUB_MENU_NAME','ROUTE')
            ->where ('ROUTE','=',$uri)
            ->get();
            $empdetailsget=DB::table('EMP_PERSONAL')
            ->select('EMPNO', 'FIRST_NAME')
            ->where('NEW_EMPNO','=',$request->search_emp)
            ->first();
//return json_encode($deptList);
    //        dd($ll)   ;
            $empType=DB::table('HRM.EMP_TYPE')
            ->select('EMP_TYPE', 'TYPE_SET', 'PRIORITY')
            ->get();
            $shiftInfo=DB::table('HRM.SHIFT_INFO')
            ->select('SHIFT_CODE', 'SHIFT_NAME', 'IN_TIME', 'OUT_TIME', 'GRACE_PERIOD', 'MEAL_TIME', 'SIN_TIME', 'SOUT_TIME', 'OT_LIMIT', 'SHIFT_IN_TIME', 'GRACE_PERIOD_2')
            ->get();
            $gradeInfo=DB::table('HRM.GRADE')
            ->select('GRADE_ID', 'GRADE_NAME', 'GRADE_TYPE')
            ->get();
            $calInfo=DB::table('HRM.CALENDER_MASTER')
            ->select('CAL_CODE', 'IS_CLOSE')
            ->where('is_close','=','N')
            ->get();
            $leaveCat=DB::table('LV_CAT_MASTER')
            ->select('LV_CAT_ID')
            ->get();
            $bankNmae=DB::table('BANK')
            ->select('BANK_NAME')
            ->get();


         return view('hrm.empentry',['data'=>$data,'menu'=>$leftmenu,'submenu'=>$submenu ,'submenu2'=>$submenu2 ,'headeer'=>$headeer,'religion'=>$religion,'companyList'=>$companyList,
         'section_list'=>$sectionList,'deptList'=>$deptList,'floorList'=>$floorList,'lineInfo'=>$LineInfo,'empType'=>$empType,'shiftInfo'=>$shiftInfo,
        'gradeInfo'=>$gradeInfo,'calInfo'=>$calInfo,'leaveCat'=>$leaveCat,'bankNmae'=>$bankNmae,'designation'=>$designation]);
        }
        catch(Exception $e)
        {
           dd($e->getMessage());
        }}
        else{
            return redirect('login');
        }
    }
    function empnewentryfind(Request $request){
        $uri = Route::getFacadeRoot()->current()->uri();
        
                if(!session('LoggedUser')==null)
        {        try
                {$companyList=DB::table('COMPANY_PROFILE')
                    ->get();
                    $religion=DB::table('RELIGION')
                    ->select('RELIGION_NAME', 'RELIGION_ID')
                    ->get();
                    $data =  DB::table('ALL_USER_INFO')
                    ->select('USER_ID', 'EMPLOYEE_ID', 'USER_GROUP_ID', 'INITIAL_PASSWORD', 'COMPANY_ID', 'USER_MOBILE',
                     DB::raw('"GET_EMP_NAME"(EMPLOYEE_ID) as EMPLOYEE_NAME'))
                    ->where('EMPLOYEE_ID','=',session('LoggedUser'))
                    ->get();
                    $leftmenu =DB::table('ALL_USER_GROUP_DETAILS')
                    ->crossJoin('ALL_MENU_HIERARCHY')
                    ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'TITLE', 'DESCRIPTION')
                    ->where('ALL_USER_GROUP_DETAILS.ENABLED','=','Y')
                    ->where('ALL_MENU_HIERARCHY.CHILD_ID','=',DB::raw('ALL_USER_GROUP_DETAILS.MENU_ITEM_ID'))
                    ->get();
                    $submenu=DB::table('ALL_USER_SUB_DETAILS')
                    ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'SUB_MENU_ID', 'SUB_MENU_1', 'SUB_MENU_2', 'SUB_MENU_NAME','ROUTE')
                    ->whereNull('SUB_MENU_2')
                    ->get();
                    $headeer =DB::table('ALL_USER_SUB_DETAILS')
                    ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'SUB_MENU_ID', 'SUB_MENU_1', 'SUB_MENU_2', 'SUB_MENU_NAME','ROUTE')
                    ->where ('ROUTE','=',$uri)
                    ->get();

                    $submenu2=DB::table('ALL_USER_SUB_DETAILS')
                    ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'SUB_MENU_ID', 'SUB_MENU_1', 'SUB_MENU_2', 'SUB_MENU_NAME','ROUTE')
                    ->whereNotNull('SUB_MENU_2')
                    ->get();
                    $empdetailsget=DB::table('EMP_PERSONAL')
                    ->select('*')
                    ->where('NEW_EMPNO','=',$request->search_emp)
                    ->get();
             dd($submenu);
                return view('hrm.empentryfind',['data'=>$data,'menu'=>$leftmenu,'submenu'=>$submenu ,'submenu2'=>$submenu2 ,'headeer'=>$headeer,'empdetailsget'=>$empdetailsget,'companyList'=>$companyList]);
                }
                catch(Exception $e)
                {
                   dd($e->getMessage());
                }}
                else{
                    return redirect('login');
                }
            }
     function logout(){
        if(session()->has('LoggedUser')){
            session()->pull('LoggedUser');
            return redirect('login');
        }}

        function empsearch(Request $request)
        { 

        $empno=DB::table('EMP_PERSONAL')
        ->select('NEW_EMPNO')
        ->where ('NEW_EMPNO','like', '%'.$request->search_key.'%')
        ->take(20)->get();
        return response()->json(['data'=>$empno]);
        }
        function index(){
            $dt=  EmpPersonal::where('EMPNO','=',101037)->with('getemp','getemploc')->get();

          //  $arrayVar = $dt->toArray();
//dd($dt->getemp());
return EmpPersonal::where('EMPNO','=',101037)->with('getemp','getemploc')->get();
            //return view('demo',['empdt'=>$dt]);
        }




        function employeePersonalInsert(Request $request){
            
          $request->validate([
            'empno'=>'required',
            'company_id'=>'required',
            
        ]);



                    if(!session('LoggedUser')==null)
            { 

                $data = $request->input();
                $religionName=DB::table('RELIGION')
                ->select('RELIGION_NAME', 'RELIGION_ID')
                ->WHERE('RELIGION_ID','=',$data['religion_id'])
    
                ->first();
                $imagename=$data['empno'].'.'.$request->file('photo')->getClientOriginalExtension();
                $signaturename=$data['empno'].'.'.$request->file('signature')->getClientOriginalExtension();
          
                $request->file('photo')->storeAs('emp_image',$imagename);
                $request->file('signature')->storeAs('emp_sign',$signaturename);
                
                try{

                
                     $employeePersonal= new EmpPersonal;
                      $employeePersonal->empno=$data['empno'];
                     $employeePersonal->card_no=$data['card_no'];
                     $employeePersonal->first_name=$data['first_name'];
                     $employeePersonal->middle_name=$data['middle_name'];
                     $employeePersonal->last_name=$data['last_name'];
                     $employeePersonal->b_name=$data['b_name'];

                        
                     $employeePersonal->dob= $data['dob'];
                     $employeePersonal->age2=$data['age'];
                     $employeePersonal->sex=$data['sex'];
                    //  $employeePersonal->marial_status=$data['marial_status'];
                     $employeePersonal->id_mark=$data['id_mark'];
                     $employeePersonal->blood_group=$data['blood_group'];
                     $employeePersonal->passport_no=$data['passport_no'];
                     $employeePersonal->place_of_issue=$data['place_of_issue'];
                     $employeePersonal->valid_till=$data['valid_till'];
                     $employeePersonal->religion_name=$religionName->religion_name;
                     $employeePersonal->nationality_desc=$data['nationality_desc'];
                     $employeePersonal->status=$data['status'];
                     $employeePersonal->father_name=$data['father_name'];
                     $employeePersonal->mother_name=$data['mother_name'];
                     $employeePersonal->husband_name=$data['husband_name'];
                     $employeePersonal->as_on=$data['as_on'];
                     $employeePersonal->age2=$data['age'];
                     $employeePersonal->hbs_test=$data['hbs_test'];
                     $employeePersonal->emp_mobile_no=$data['emp_mobile_no'];
                     $employeePersonal->national_id_no=$data['national_id_no'];
                     $employeePersonal->id_card_issue=$data['id_card_issue'];
                     $employeePersonal->company_id=$data['company_id'];
                     $employeePersonal->sms_mobile_no=$data['sms_mobile_no'];
                     $employeePersonal->new_empno=$data['empno'];
                     $employeePersonal->birthday_id=$data['birthday_id'];
                     $employeePersonal->last_education=$data['last_education'];
                     $employeePersonal->insert_by=session('LoggedUser');
                     $employeePersonal->update_by=session('LoggedUser');
                     //$employeePersonal->office_food=$data['office_food'];
                     $employeePersonal->religion_id=$data['religion_id'];
                     $employeePersonal->emp_img= $imagename;
                     $employeePersonal->emp_sign= $signaturename;
                     $employeePersonal->save();
                      return response()->json([
                        'status' => 200,
                    ]);

                }  catch(Exception $e){


                }


            }}
            function employeeOfficialInsert(Request $request){
            
                if(!session('LoggedUser')==null)
        { 

                                $officialdata = $request->input();
                    $employeeOffical =new EmpOfficial();
                    $employeeOffical->empno=$officialdata['empof_id'];
                    $employeeOffical->company_id=$officialdata['company_id'];
                    // $employeeOffical->company_name=$officialdata['company_name'];
                    $employeeOffical->dept_no=$officialdata['dept_no'];
                    // $employeeOffical->dept_name=$officialdata['dept_name'];
                    $employeeOffical->section_no=$officialdata['section_no'];
                    // $employeeOffical->section_name=$officialdata['section_name'];
                    $employeeOffical->emp_type=$officialdata['emp_type'];
                    $employeeOffical->grade_id=$officialdata['grade_id'];
                    // $employeeOffical->grade_name=$officialdata['grade_name'];
                    $employeeOffical->joining_date=$officialdata['joining_date'];
                    $employeeOffical->work_ent=$officialdata['work_ent'];
                    $employeeOffical->ot_ent=$officialdata['ot_ent'];
                    $employeeOffical->tran_ent=$officialdata['tran_ent'];
                    // $employeeOffical->pes_ent=$officialdata['pes_ent'];
                    $employeeOffical->tax_ent=$officialdata['tax_ent'];
                    $employeeOffical->pf_ent=$officialdata['pf_ent'];
                    $employeeOffical->termination_date=$officialdata['termination_date'];
                    $employeeOffical->resigned_date=$officialdata['resigned_date'];
                    $employeeOffical->weekly_off=$officialdata['weekly_off'];
                    $employeeOffical->bank_name=$officialdata['bank_name'];
                    $employeeOffical->tin_no=$officialdata['tin_no'];
                    $employeeOffical->ac_no=$officialdata['ac_no'];
                    $employeeOffical->cal_code=$officialdata['cal_code'];
                    $employeeOffical->shift_code=$officialdata['shift_code'];
                    // $employeeOffical->s_group_name=$officialdata['s_group_name'];
                    $employeeOffical->lv_cat_id=$officialdata['lv_cat_id'];
                    $employeeOffical->gross=$officialdata['gross'];
                    // $employeeOffical->shift_name=$officialdata['shift_name'];
                    $employeeOffical->des_id=$officialdata['des_id'];
                    // $employeeOffical->des_name=$officialdata['des_name'];
                    $employeeOffical->floor_id=$officialdata['floor_id'];
                    $employeeOffical->line=$officialdata['line'];
                    // $employeeOffical->line_info=$officialdata['line_info'];
                    // $employeeOffical->piece_rate=$officialdata['piece_rate'];
                    $employeeOffical->pro_fund=$officialdata['pro_fund'];
                    // $employeeOffical->shift_rostering=$officialdata['shift_rostering'];
                    $employeeOffical->bank_ac_no=$officialdata['bank_ac_no'];
                    $employeeOffical->tax_deduction=$officialdata['tax_deduction'];
                    $employeeOffical->service_book_number=$officialdata['service_book_number'];
                    $employeeOffical->other_allowance=$officialdata['other_allowance'];
                    $employeeOffical->conform_date=$officialdata['conform_date'];
                    $employeeOffical->insert_by=session('LoggedUser');
                    $employeeOffical->update_by=session('LoggedUser');
                    $employeeOffical->res_ent=$officialdata['res_ent'];


                                            $employeeOffical->save();
                      return response()->json([
                        'status' => 200,
                    ]);


        }else{
          return redirect('login');

        }
    
    }

    function increment_details(){
        $uri = Route::getFacadeRoot()->current()->uri();

        $data =  DB::table('ALL_USER_INFO')
        ->select('USER_ID', 'EMPLOYEE_ID', 'USER_GROUP_ID', 'INITIAL_PASSWORD', 'COMPANY_ID', 'USER_MOBILE',
         DB::raw('"GET_EMP_NAME"(EMPLOYEE_ID) as EMPLOYEE_NAME'))
        ->where('EMPLOYEE_ID','=',session('LoggedUser'))
        ->get();
        $leftmenu =DB::table('ALL_USER_GROUP_DETAILS')
        ->crossJoin('ALL_MENU_HIERARCHY')
        ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'TITLE', 'DESCRIPTION')
        ->where('ALL_USER_GROUP_DETAILS.ENABLED','=','Y')
        ->where('ALL_MENU_HIERARCHY.CHILD_ID','=',DB::raw('ALL_USER_GROUP_DETAILS.MENU_ITEM_ID'))
        ->get();
        $submenu=DB::table('ALL_USER_SUB_DETAILS')
        ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'SUB_MENU_ID', 'SUB_MENU_1', 'SUB_MENU_2', 'SUB_MENU_NAME','ROUTE')
        ->whereNull('SUB_MENU_2')

        ->get();
        $headeer =DB::table('ALL_USER_SUB_DETAILS')
        ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'SUB_MENU_ID', 'SUB_MENU_1', 'SUB_MENU_2', 'SUB_MENU_NAME','ROUTE')
        ->where ('ROUTE','=',$uri)
        ->get();
        $empnoList=DB::table('EMP_PERSONAL')
        ->select('EMPNO')
        ->where('status','=','Active')
        ->orderBy('EMPNO','asc')
        
        ->get();
        $submenu2=DB::table('ALL_USER_SUB_DETAILS')
        ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'SUB_MENU_ID', 'SUB_MENU_1', 'SUB_MENU_2', 'SUB_MENU_NAME','ROUTE')
        ->whereNotNull('SUB_MENU_2')
        ->get();

        $designation=DB::table('DESIGNATION_DETAILS')
->select('DES_ID', 'DESIGNATION_NAME', 'IN_SHORT', 'GRADE_ID', 'IN_BENGALI', 'BNS_AMNT', 'NIGHT_BILL')
->get();
//return json_encode($deptList);
//        dd($ll)   
return view('hrm.increment',['data'=>$data,'menu'=>$leftmenu,'submenu'=>$submenu ,'headeer'=>$headeer,'submenu2'=>$submenu2,'empnoList'=>$empnoList,'designation'=>$designation]);

    }
    function getAllEmpList(){
        $uri = Route::getFacadeRoot()->current()->uri();

        if(!session('LoggedUser')==null)
{        try
        {
            $yaerList=DB::table('DUAL')
            ->select(DB::raw('TO_CHAR(SYSDATE,\'YYYY\')-LEVEL+1 YEAR'))
            ->whereRaw('TO_CHAR(SYSDATE,\'YYYY\')-LEVEL+1 > \'1985\'CONNECT BY LEVEL <=80')
            ->get();
            $companyList=DB::table('COMPANY_PROFILE')
            ->select('COMPANY_ID','COMPANY_NAME')
            ->orderBy('COMPANY_ID','desc')
             ->get();
                    $deptList=DB::table('DEPT')
                    ->orderBy('DEPT_NO','asc')
                  //  ->pluck('dept_no','dept_name');
                    ->get();
                    $floorList=DB::table('FLOOR')
                    ->orderBy('Floor_id','asc')
                  //  ->pluck('dept_no','dept_name');
                    ->get();

                    $LineInfo=DB::table('LINE_INFO')
                    ->orderBy('LINE','asc')
                  //  ->pluck('dept_no','dept_name');
                    ->get();

                    $submenu2=DB::table('ALL_USER_SUB_DETAILS')
                    ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'SUB_MENU_ID', 'SUB_MENU_1', 'SUB_MENU_2', 'SUB_MENU_NAME','ROUTE')
                    ->whereNotNull('SUB_MENU_2')
                    ->get();
            $sectionList=DB::table('SECTION')
            ->orderBy('SECTION_NO','asc')
            ->get();
            $religion=DB::table('RELIGION')
            ->select('RELIGION_NAME', 'RELIGION_ID')
            ->orderBy('RELIGION_ID','asc')
            ->get();
            $data =  DB::table('ALL_USER_INFO')
            ->select('USER_ID', 'EMPLOYEE_ID', 'USER_GROUP_ID', 'INITIAL_PASSWORD', 'COMPANY_ID', 'USER_MOBILE',
             DB::raw('"GET_EMP_NAME"(EMPLOYEE_ID) as EMPLOYEE_NAME'))
            ->where('EMPLOYEE_ID','=',session('LoggedUser'))
            ->get();
            $leftmenu =DB::table('ALL_USER_GROUP_DETAILS')
            ->crossJoin('ALL_MENU_HIERARCHY')
            ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'TITLE', 'DESCRIPTION')
            ->where('ALL_USER_GROUP_DETAILS.ENABLED','=','Y')
            ->where('ALL_MENU_HIERARCHY.CHILD_ID','=',DB::raw('ALL_USER_GROUP_DETAILS.MENU_ITEM_ID'))
            ->get();
            $submenu=DB::table('ALL_USER_SUB_DETAILS')
            ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'SUB_MENU_ID', 'SUB_MENU_1', 'SUB_MENU_2', 'SUB_MENU_NAME','ROUTE')
            ->whereNull('SUB_MENU_2')

            ->get();
            $headeer =DB::table('ALL_USER_SUB_DETAILS')
            ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'SUB_MENU_ID', 'SUB_MENU_1', 'SUB_MENU_2', 'SUB_MENU_NAME','ROUTE')
            ->where ('ROUTE','=',$uri)
            ->get();
$empList=DB::table('EMP_PERSONAL')
->crossJoin('EMP_OFFICIAL')
->select(DB::raw('GET_COMPANY(EMP_PERSONAL.COMPANY_ID) as COMPANY_NAME'), 'EMP_PERSONAL.EMPNO', 'EMP_PERSONAL.NEW_EMPNO', DB::raw('EMP_PERSONAL.FIRST_NAME||\' \'||EMP_PERSONAL.MIDDLE_NAME||\' \'||EMP_PERSONAL.LAST_NAME EMPNAME'), 'EMP_PERSONAL.FATHER_NAME', 'EMP_PERSONAL.MOTHER_NAME', 'EMP_PERSONAL.RELIGION_NAME', 'EMP_PERSONAL.SEX', 'EMP_OFFICIAL.JOINING_DATE', 'EMP_PERSONAL.EMP_MOBILE_NO', 'EMP_OFFICIAL.AC_NO')
->where('EMP_PERSONAL.EMPNO','=',DB::raw('EMP_OFFICIAL.EMPNO'))
->where('EMP_PERSONAL.STATUS','=','Active')
->get();
return view('hrm.emplist',['data'=>$data,'menu'=>$leftmenu,'submenu'=>$submenu ,'submenu2'=>$submenu2,'headeer'=>$headeer,'empList'=>$empList]);
}
catch(Exception $e){


}

}
    }
    public function tableData($empId){
      $getTable=DB::table('INCREMENT_INFO')
      ->select('EMPNO','PREV_DESIGNATION','CUR_DESIGNATION','PREV_OT_ENT','CUR_OT_ENT','PREV_GROSS','INCR_TYPE','INCREMENT_AMT','CUR_GROSS','INCR_DATE','REMARK_TEXT','PREV_HOUSE_RENT','PREV_MEDICAL','PREV_BASIC','CUR_HOUSE_RENT','CUR_MEDICAL','CUR_BASIC','EFFECTIVE_DATE')
      ->where('EMPNO','=',$empId)
      ->get();

      return view('hrm.incr_table',['tableList'=>$getTable]);
  }





     public function getEmpDet(Request $request){
      $data = $request->input();

      $empDetails= DB::table('hrm.emp_increment_vw')
->select('NEW_EMPNO','EMPNO','EMP_NAME',DB::raw('TO_CHAR(JOINING_DATE,\'YYYY-MM-DD\') JOINING_DATE'),'DEPT_NAME','SECTION_NAME','DES_NAME',DB::raw('TO_CHAR(LAST_INCREMENT_DATE,\'YYYY-MM-DD\') LAST_INCREMENT_DATE'))
->where('EMPNO','=',$data['empno'])
->orderBy('NEW_EMPNO','ASC')
->get();
return response()->json($empDetails);

     }
  


public function getPrevGross(Request $request){
  $data = $request->input();

  $getPrevGross=DB::table('EMP_PERSONAL')
  ->select(DB::raw('EMP_PERSONAL.first_name || \' \' ||  EMP_PERSONAL.middle_name || \' \' ||EMP_PERSONAL.last_name emp_name'),'EMP_OFFICIAL.section_name','EMP_OFFICIAL.des_name','EMP_OFFICIAL.ot_ent','EMP_OFFICIAL.gross','emp_payment.basic','emp_payment.hr_amt','emp_payment.mr_amt')
  ->crossJoin('EMP_OFFICIAL')
  ->crossJoin('hrm.emp_payment')
  ->where(function ($query) { $query->whereRaw('EMP_OFFICIAL.EMPNO = EMP_PERSONAL.EMPNO');})
  ->where(function ($query) { $query->whereRaw('EMP_PERSONAL.EMPNO = emp_payment.EMPNO');})
  ->where('emp_personal.status','=','Active')
  ->where('EMP_PERSONAL.empno','=','101037')
  ->get();
return response()->json($getPrevGross);

}


  public function empaddressSave(Request $request){
    if(!session('LoggedUser')==null)
    { 
      $empaddressdata = $request->input();
        $empadress=new Emp_locationModel;
        $empadress-> empno=$empaddressdata['empadempno'];
$empadress->p_address=$empaddressdata['p_address'];
$empadress->p_city=$empaddressdata['p_city'];
$empadress->p_district=$empaddressdata['p_district'];
$empadress->p_pin_code=$empaddressdata['p_pin_code'];
$empadress->p_phone=$empaddressdata['p_phone'];
$empadress->p_fax=$empaddressdata['p_fax'];
$empadress->p_cperson=$empaddressdata['p_cperson'];
$empadress->r_address=$empaddressdata['r_address'];
$empadress->r_city=$empaddressdata['r_city'];
$empadress->r_district=$empaddressdata['r_district'];
//$empadress->r_pin_cod=$empaddressdata['r_pin_cod'];
$empadress->r_phone=$empaddressdata['r_phone'];
$empadress->r_fax=$empaddressdata['r_fax'];
$empadress->r_mobile=$empaddressdata['r_mobile'];
$empadress->r_email=$empaddressdata['r_email'];
$empadress->r_cperson=$empaddressdata['r_cperson'];
$empadress->p_village=$empaddressdata['p_village'];
$empadress->p_post_off=$empaddressdata['p_post_office'];
$empadress->p_police_station=$empaddressdata['p_police_station'];
$empadress->save();
return response()->json([
  'status' => 200,
]);
    }else{
      return redirect('login');

    }
    
  }




  public function empeduSave(Request $request){
    if(!session('LoggedUser')==null)
    { 
      $empedudata = $request->input();
        $empedu=new Emp_qualificationModel;
        $empedu->empno=$empedudata['empnoedu'];
$empedu->name_of_ins=$empedudata['name_of_ins'];
//$empedu->passed_exam=$empedudata['passed_exam'];
$empedu->division=$empedudata['division'];
$empedu->year=$empedudata['year'];
$empedu->board=$empedudata['board'];
$empedu->marks=$empedudata['marks'];
$empedu->subject=$empedudata['subject'];
$empedu->save();
     
return response()->json([
  'status' => 200,
]);
    }else{
      return redirect('login');

    }
    
  }




  public function empShortSave(Request $request){
    if(!session('LoggedUser')==null)
    { 

      $empshortCourse = $request->input();
      $empshor=new Emp_ShortModel;
      $empshor->empno=$empshortCourse['empnoshtcourse'];
      $empshor->course_name=$empshortCourse['course_name'];
      $empshor->conducted_by=$empshortCourse['conducted_by'];
      $empshor->c_from=$empshortCourse['c_from'];
      // $empshor->c_to=$empshortCourse['total_day'];
      $empshor->certificate=$empshortCourse['certificate'];
      $empshor->total_day=$empshortCourse['total_day'];

      $empshor->save();
     
      return response()->json([
        'status' => 200,
      ]);
    }else{
      return redirect('login');

    }


  }


  public function empNomineeSave(Request $request){
    if(!session('LoggedUser')==null)
    { 

      $empNominee = $request->input();
      $empFami=new Emp_familyModel ;
      $empFami->empno=$empNominee['empnoNominee'];
      $empFami->depd_name=$empNominee['depd_name'];
      $empFami->relationship=$empNominee['relationship'];
      $empFami->d_age=$empNominee['d_age'];
      $empFami->d_sex=$empNominee['d_sex'];
      $empFami->percentage=$empNominee['percentage'];
      $empFami->depent_name_bangla=$empNominee['relation_bn'];
      $empFami->address=$empNominee['address'];
      $empFami->save();
      return response()->json([
        'status' => 200,
      ]);
    }else{
      return redirect('login');

    }


  }
  
  public function empHistory(Request $request){
    if(!session('LoggedUser')==null)
    { 

      $empHisto = $request->input();
      $empJob=new Emp_historyModel ;
      $empJob->empno=$empHisto['empnojob'];
      $empJob->join_as=$empHisto['join_as'];
      $empJob->designation=$empHisto['designation'];
      $empJob->work_location=$empHisto['work_location'];
      $empJob->join_date=$empHisto['join_date'];

      $empJob->save();
      return response()->json([
        'status' => 200,
      ]);
    }else{
      return redirect('login');

    }


  }

  public function empTraining(Request $request){
    if(!session('LoggedUser')==null)
    { 

      $empTraining = $request->input();
      $empTrain=new Emp_trainingModel ;
      $empTrain->empno=$empTraining['empnotraining'];
      $empTrain->t_title=$empTraining['t_title'];
      $empTrain->t_conducted_by=$empTraining['t_conducted_by'];
      $empTrain->t_from=$empTraining['t_from'];
      $empTrain->t_to=$empTraining['t_to'];
      $empTrain->t_certificate=$empTraining['t_certificate'];
      $empTrain->skill_type=$empTraining['skill_type'];
      $empTrain->to_days=$empTraining['to_days'];

      $empTrain->save();
      return response()->json([
        'status' => 200,
      ]);
    }else{
      return redirect('login');

    }


  }
  public function empExp(Request $request){
    if(!session('LoggedUser')==null)
    { 

      $empExperience = $request->input();
      $empExpe=new Emp_work_expModel ;
      $empExpe->empno=$empExperience['empnoexp'];
      $empExpe->organization=$empExperience['organization'];
      $empExpe->d_from=$empExperience['d_from'];
      $empExpe->d_to=$empExperience['d_to'];
      //$empExpe->t_to=$empExperience['total_years'];
      $empExpe->leave_reason=$empExperience['leave_reason'];
      $empExpe->prv_emp_no=$empExperience['prv_emp_no'];
      $empExpe->org_address=$empExperience['org_address'];
      $empExpe->org_tel=$empExperience['org_tel'];
      $empExpe->last_sal_drawn=$empExperience['last_sal_drawn'];
      $empExpe->total_days=$empExperience['total_years'];
      $empExpe->designation=$empExperience['designation'];


      $empExpe->save();
      return response()->json([
        'status' => 200,
      ]);
    }else{
      return redirect('login');

    }


  }

public function increment_Entry(Request $request)
{
  $data=$request->input();
  $inDt= new IncrementDetailsModel;
  $inDt->empno=$data['empno'];
  // $inDt->section=$data[''];
  $inDt->prev_designation=$data['prev_designation'];
  $inDt->emp_name=$data['empname'];
  $inDt->prev_gross=$data['prev_gross'];
  $inDt->prev_house_rent=$data['prev_house_rent'];
  $inDt->prev_medical=$data['prev_medical'];
  $inDt->increment_amt=$data['increment_amt'];
  $inDt->cur_gross=$data['cur_gross'];
  $inDt->cur_designation=$data['cur_designation'];
  $inDt->cur_ot_ent=$data['cur_ot_ent'];
  $inDt->prev_ot_ent=$data['prev_ot_ent'];
  // $inDt->curr_grade=$data[''];
  $inDt->remark_text=$data['remark_text'];
  $inDt->effective_date=$data['effective_date'];
  $inDt->incr_type=$data['incr_type'];
  $inDt->incr_date=$data['incr_date'];
  $inDt->cur_basic=$data['cur_basic'];
  $inDt->prev_basic=$data['prev_basic'];
  $inDt->cur_house_rent=$data['cur_house_rent'];
  $inDt->cur_medical=$data['cur_medical'];
  $inDt->save();
  return response()->json([
    'status' => 200,
  ]);
}


}