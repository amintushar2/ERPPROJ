<?php

namespace App\Http\Controllers;
use Session;
use DB;
use Illuminate\Http\Request;
use App\Models\LoanMaster;
use App\Models\EmpLoanDetails;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route ;

class LoanController extends Controller
{
    public function loan(){
$getCompany=DB::table('COMPANY_PROFILE')
->select('COMPANY_ID','COMPANY_NAME')
->get();
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
//return json_encode($deptList);
//        dd($ll)   





        
     return view ('loan',['data'=>$data,'getCompany'=>$getCompany,'menu'=>$leftmenu,'submenu'=>$submenu ,'headeer'=>$headeer,'submenu2'=>$submenu2,'empnoList'=>$empnoList]);

    }

    public function storeer(Request $request)
    {
        $data = $request->input();
   
$loanId=DB::table('EMP_LOAN_MASTER')
->select(DB::raw('LPAD(NVL(MAX(TO_NUMBER(SUBSTR (LOAN_APP_NO,8))),0)+1,4,0) AA'))
->where('COMPANY_ID','=',$data['company_no'])
->first();
//dd($loanId);
$loan_no='F-'.$data['company_no'].'/'.$loanId->aa;
        if($request->ajax())
        {
            try{
                $loanMaster=new LoanMaster;
                $loanMaster->emp_no=$data['emp_no'];
                $loanMaster->loan_app_no=$loan_no;
                $loanMaster->joining_date=$data['joining_date'];
                $loanMaster->des_name=$data['designation'];
                $loanMaster->dept_no=$data['dept_no'];
                // $loanMaster->dept_name=$data['dept_name'];
                $loanMaster->section_no=$data['section_no'];
                // $loanMaster->section_name=$data['section_name'];
                $loanMaster->gross_amount=$data['gross_amount'];
                // $loanMaster->joining_date=$data['designation'];
                $loanMaster->application_date=$data['application_date'];
                $loanMaster->loan_approved_date=$data['loan_approved_date'];
                $loanMaster->sanction_amount=$data['sanction_amount'];
                // $loanMaster->pre_balance_amount=$data['designation'];
                $loanMaster->first_install_date=$data['first_install_date'];
                $loanMaster->period=$data['period'];
                $loanMaster->ref_des_name=$data['ref_name'];
                $loanMaster->new_instt_date=$data['new_instt_date'];
                $loanMaster->new_period=$data['new_period'];
                $loanMaster->company_id=$data['company_no'];
                $loanMaster->monthly_installment=$data['installment_size'];
                
                // $loanMaster->joining_date=$data['joining_date'];
                $loanMaster->save();
                return response()->json([
                    'status2' => 200,
                    'loan_nooo' => $loan_no,
                   'jDate' =>$data['joining_date'],
              
                ], 200);
            }catch(Exception $e){
              
            }
            
        }
    }



    function getEmpNO($comid){
     $getEmpList=   DB::table('EMP_Personal')
->select('EMPNO')
->where('company_id','=',$comid)
->take(20)->get();
return response()->json(['data'=>$getEmpList]);
    }

    function getEMPdetails(Request $request){
        $data = $request->input();

        $empDetails=DB::table(DB::raw('EMP_PERSONAL EP'))
        ->select(DB::raw('EP.FIRST_NAME||\' \'||EP.MIDDLE_NAME||\' \'||EP.LAST_NAME EMP_NAME'),'EO.DEPT_NO','EO.SECTION_NO','EO.DEPT_NAME','EP.EMPNO','EP.NEW_EMPNO','EO.SECTION_NAME','EO.DES_NAME',DB::raw('TO_CHAR(EO.JOINING_DATE,\'YYYY-MM-DD\') JOINING_DATE'),'EO.GROSS')
        ->crossJoin(DB::raw('EMP_OFFICIAL EO'))
        ->whereRaw('EP.EMPNO = EO.EMPNO')
        ->where('EP.EMPNO','=',$data['empno'])
        ->whereRaw('EO.COMPANY_ID = NVL('.$data['comId'].',EO.COMPANY_ID)')
        ->where('EO.EMP_TYPE','=','Permanent')
        ->where('EP.STATUS','=','Active')
        ->get();
        
        return response()->json($empDetails);

    }




    function storeerdetails(Request $request)
    {  
      



        $nwData = $request->input();
        $loanAppNo = $nwData['loanAppNo'];
        $install_no = $nwData['install_no'];
        $pbbom = $request->get('pbbom');
        $installAmount = $request->get('installAmount');
        $firdtInsDate = $request->get('firdtInsDate');
        $pbeomr = $request->get('pbeomr');
        $status = $request->get('status');
        $company_id = '100';
        $is_voucher = 'N';
        $count_emp = count($loanAppNo);

       

        for($i = 0; $i< $count_emp; $i++)
        {    if($loanAppNo[$i]!=null){
            $loanMaster=new EmpLoanDetails;
            $loanMaster->loan_app_no=$loanAppNo[$i];
            $loanMaster->install_no=$install_no[$i];
            $loanMaster->install_amount=$installAmount[$i];
            $loanMaster->install_date=$firdtInsDate[$i];
            $loanMaster->pbbom=$pbbom[$i];
            // $loanMaster->paydate=$loanAppNo[$i];
            $loanMaster->pbeom=$pbeomr[$i];
            $loanMaster->status=$status[$i];
            $loanMaster->company_id='100';
            // $loanMaster->is_voucher=$is_voucher[$i];
            $loanMaster->save();
        }}
        return response()->json([
            'status'=>200,
            'message' => "success",
            'count_emp' => $installAmount
    ]);

    } 



    }


