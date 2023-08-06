<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Doctrine\DBAL\Driver\PDOConnection;
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

        return view('salary.sal_process',['compList'=>$comName,'listYear'=>$listYear,'paymentDateList'=>$paymentDateList]);
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
}