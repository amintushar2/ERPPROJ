<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Doctrine\DBAL\Driver\PDOConnection;

use Session;
use Illuminate\Http\Request;
use PDO;

use App\Models\Attendance;
use App\Models\AttendanceRaw;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route ;
use Carbon\Carbon;

use Rats\Zkteco\Lib\ZKTeco;

class AttendanceController extends Controller
{

    public function attddevice()
    {
        $companyList=DB::table('COMPANY_PROFILE')
        ->select('COMPANY_ID','COMPANY_NAME')
        ->orderBy('COMPANY_ID','desc')
         ->get();
        return view('hrm.attd.attdevice',['companyList'=>$companyList]);
    }


public function getAttendenceData(Request $request){
    $data = $request->input();

    if( $zk = new ZKTeco($data['arrData'])){

        if ($zk->connect()){
              $atte=   $zk->getAttendance(); 
              if ($atte==0){
                return 'Error';
    
              }
              else{
                if($atte>0){
                    foreach($atte as $atte){
                        $count_dta=count($atte);
                       // dd($count_dta);
                        //return $atte[];

                        $attData = new AttendanceRaw;
                        $attData->mach_no=$atte['state'];
                        $attData->card_no=$atte['id'];
                        $attData->atnd_time=Carbon::parse($atte['timestamp'])->format('His');
                        $attData->atnd_date=Carbon::parse($atte['timestamp'])->format('Y-m-d');
                       // $attData->card_no=$atte['id'];
                        $attData->save();

                        // for($i = 0; $i<$count_dta; $i++)
                        // { 
                        //     //return $atte[$i]->state;

                         
        
        
                        // }


                    }
                    return response()->json([
                        'status' => 200                            
                    ], 200);}






    
              }
    
            }else{
                 return response()->json();
            }
        }else{
            return 'errror';
        }
    return view('hrm.attd.atdProcess');
}

public function atdFullProcess(Request $request){
    $data = $request->input();
    $company_id=$data['company_id'];

    //tat_attendance_process
   // dd( $data );

    try{


        // $procedureName = 'HRM.TAT_ATTENDANCE_PROCESSFINAL';
 
        // $bindings = [
        //     'p_company'  => $company_id,
        // ];
         
        // $result = DB::executeProcedure($procedureName, $bindings);
         
        // dd($result);







        // $dd=DB::statement('begin HRM.TAT_ATTENDANCE_PROCESSFINAL(:param1); END;', [
        //     'param1' => $company_id,
    
        // ]);

        $pdo = DB::connection()->getPdo();

        $stmt = $pdo->prepare("begin HRM.TAT_ATTENDANCE_PROCESSFINAL('".$company_id."');end;");
        // //  $stmt->bindParam(':p_company',$company_id, PDO::PARAM_STR);
         $stmt->execute();

return response()->json([
    'status' => 200                            
], 200);

        

}catch(\Illuminate\Database\QueryException $e){
    return response()->json([
        $e                           
    ]);     
} 



}













    public function empData(){
        $empList=DB::table('EMP_OFFICIAL')
        ->select('EMPNO','DESIGNATION_NAME')
        // ->where('status','=','Active')
        ->orderBy('EMPNO','asc')
        
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

      return view('hrm.attd.attendance',['empList'=>$empList,'data'=>$data,'getCompany'=>$getCompany,'menu'=>$leftmenu,'submenu'=>$submenu ,'headeer'=>$headeer,'submenu2'=>$submenu2,'empnoList'=>$empnoList]);
    }

    public function attendData(Request $request)
    {
        $data = $request->input();
        // $dd=DB::table('ATTENDANCE_DETAILS')
        // ->select('EMPNO','ATT_DATE','LATE','STATUS','STATUS2','IN_TIME','IN_TIME2','OUT_TIME','OUT_TIME2','OTHOUR','OTHOUR2','EXTRAOT','LATE_EXTRA','EMPNO_NEW')
        // ->whereRaw('ATT_DATE = TO_DATE(\''.$data['fromDate'].'\',\'YYYY-MM-DD\')')
        // ->get();
        // return response()->json([$dd]);
        
        // return response()->json([$request->all()]);
        // dd($data);
        
        if($data['in_time']==null){

            $getData=DB::table('ATTENDANCE_DETAILS')
            ->select('EMPNO','ATT_DATE','LATE','STATUS','STATUS2','IN_TIME','IN_TIME2','OUT_TIME','OUT_TIME2','OTHOUR','OTHOUR2','EXTRAOT','LATE_EXTRA','EMPNO_NEW')
            ->whereNull('IN_TIME')
            ->whereRaw('ATT_DATE = TO_DATE(\''.$data['fromDate'].'\',\'YYYY-MM-DD\')')
            ->get();
           return view('hrm.attd.attn_table',['tableData'=>$getData]);

        }
        
        else if($data['out_time']==null){

            $getData=DB::table('ATTENDANCE_DETAILS')
            ->select('EMPNO','ATT_DATE','LATE','STATUS','STATUS2','IN_TIME','IN_TIME2','OUT_TIME','OUT_TIME2','OTHOUR','OTHOUR2','EXTRAOT','LATE_EXTRA','EMPNO_NEW')
            ->whereNull('OUT_TIME')
            ->whereRaw('ATT_DATE = TO_DATE(\''.$data['fromDate'].'\',\'YYYY-MM-DD\')')
            ->get();
            return view('attn_table',['tableData'=>$getData]);

        }else if($data['out_time']==null && $data['in_time']==null ){

            $getData=DB::table('ATTENDANCE_DETAILS')
            ->select('EMPNO','ATT_DATE','LATE','STATUS','STATUS2','IN_TIME','IN_TIME2','OUT_TIME','OUT_TIME2','OTHOUR','OTHOUR2','EXTRAOT','LATE_EXTRA','EMPNO_NEW')
            ->whereRaw('ATT_DATE = TO_DATE(\''.$data['fromDate'].'\',\'YYYY-MM-DD\')')
            ->get();
            return view('attn_table',['tableData'=>$getData]);

        }else if($data['empno']!=null){
            $getData=DB::table('ATTENDANCE_DETAILS')
            ->select('EMPNO','ATT_DATE','LATE','STATUS','STATUS2','IN_TIME','IN_TIME2','OUT_TIME','OUT_TIME2','OTHOUR','OTHOUR2','EXTRAOT','LATE_EXTRA','EMPNO_NEW')
            ->where('EMPNO','=',$data['empno'])
            ->whereRaw('ATT_DATE = TO_DATE(\''.$data['fromDate'].'\',\'YYYY-MM-DD\')')
            ->get();
            return view('attn_table',['tableData'=>$getData]);
        }
        else {
            return 'error';
        }
        
    }

    public function store(Request $request){
        // $nwData = $request->all();
        // return response()->json([$nwData]);

        // if($request->ajax())
        // {
        //     try{
        //         $attData = new Attendance;
    
        //         $attData->in_time = $nwData['in_time'];
        //         $attData->in_time2 = $nwData['in_time2'];
        //         $attData->out_time = $nwData['out_time'];
        //         $attData->out_time2 = $nwData['out_time2'];
    
        //         // $attData->save();
    
        //         return response()->json([
        //             'status'=> 200 ,
        //         ]);
        //     }catch(Exception $e){
        //         return redirect('attendance')->with('failed', "operation failed");
        //     }
        // }else{
        //     return redirect('attendance')->with('failed', "operation failed");
        // }
            $nwData = $request->input();
            $empId = $nwData['empno_new'];
            $att_date = $nwData['att_date'];
            $inTime = $request->get('in_time');
            $inTime2 = $request->get('in_time2');
            $outTime = $request->get('out_time');
            $outTime2 = $request->get('out_time2');
            $count_emp = count($empId);

            for($i = 0; $i< $count_emp; $i++)
            {    if($inTime2[$i]!=null){
                $attendance = Attendance::where('EMPNO_NEW','=',$empId[$i])->whereRaw('ATT_DATE = TO_DATE(\''.$att_date[$i].'\',\'YYYY-MM-DD\')');
                $attendance->update([
                    'in_time2'=>Carbon::parse($att_date[$i].' '. $inTime2[$i])->toDateTimeString(),

                    'in_time'=>Carbon::parse($att_date[$i].' '. $inTime[$i])->toDateTimeString(),
                    'out_time'=>Carbon::parse($att_date[$i].' '. $outTime[$i])->toDateTimeString(),
                    'out_time2'=>Carbon::parse($att_date[$i].' '. $outTime2[$i])->toDateTimeString(),
                ]);

            }else {
                return 'error';
            }
                
            }
        
        }
    }