<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Doctrine\DBAL\Driver\PDOConnection;
use Illuminate\Support\Facades\Route ;
use Carbon\Carbon;

use PDO;
class SalProcessController extends Controller
{
    public function salProcess(){
        $comName = DB::table('COMPANY_PROFILE')
        ->select('COMPANY_ID','COMPANY_NAME')
        ->orderBy('COMPANY_ID','asc')
        ->get();

        $listYear=DB::table(DB::raw('DUAL CONNECT BY LEVEL <= 20'))
        ->select(DB::raw('(TO_CHAR(SYSDATE,\'YYYY\')-LEVEL+1) YEARLIST'))
        ->get();

        $paymentDateList=DB::table('HRM.SALARY_PAYMENT_INFO')
        ->distinct()
        ->select('PAYMENT_DATE')
        ->orderBy('PAYMENT_DATE','DESC')
        ->get();


        
        $uri = Route::getFacadeRoot()->current()->uri();

       

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




        return view('salary.sal_process',['compList'=>$comName,'listYear'=>$listYear,'paymentDateList'=>$paymentDateList,'data'=>$data,'getCompany'=>$getCompany,'menu'=>$leftmenu,'submenu'=>$submenu ,'headeer'=>$headeer,'submenu2'=>$submenu2,'empnoList'=>$empnoList]);
    }

    public function salFullProcess(Request $request){
        $data = $request->input();
        $company_id=$data['company_name'];
        $date2=$data['date2'];
        $date1=$data['date1'];
        //tat_attendance_process
       // dd( $data );
        $arg=0;
        try{
            $pdo = DB::getPdo();

            $stmt = $pdo->prepare("begin  HRM.sal_main(to_date(:todays_date,'DD-Mon-YYYY'), to_date(:end_date,'DD-Mon-YYYY'),:emp_type_arg,:p_company); end;");
            $stmt->bindParam(':todays_date',$date1, PDO::PARAM_STR);
            $stmt->bindParam(':end_date',$date2, PDO::PARAM_STR);
            $stmt->bindParam(':emp_type_arg',$arg, PDO::PARAM_INT);
            $stmt->bindParam(':p_company',$company_id, PDO::PARAM_INT);
 
            $stmt->execute();

    return response()->json([$stmt,
        'status2' => 200                            
    ], 200);

            

    }catch(\Illuminate\Database\QueryException $e){
        return response()->json([
            $e                           
        ]);     
    } 



}


public function salProcessDell(Request $request){

        $data = $request->input();

        $destryfind =DB::table('HRM.SALARY_PAYMENT_INFO')
        ->distinct()
        ->select('PAYMENT_DATE')
       -> whereDate('PAYMENT_DATE', '=', Carbon::parse($data['date1'])->toDateString())
        // ->whereDate('PAYMENT_DATE',$data['date1'])
        ->where('COMPANY_ID','=',$data ['company_name'])
        ->first();

        
    if (!optional($destryfind)->payment_date == null) {
        try{
        $destroy = DB::table('SALARY_PAYMENT_INFO')
        -> whereDate('PAYMENT_DATE', '=', Carbon::parse($data['date1'])->toDateString())
        ->where('COMPANY_ID', '=', $data ['company_name'])
        ->delete();
            return response()->json([
                'status2' => 200,
                ]);

            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json($e->getCode());

            }
    }








return $data;
}
}