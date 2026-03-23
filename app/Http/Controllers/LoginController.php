<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Session;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route ;


class LoginController extends Controller
{
    function login(){
        if(!session('LoggedUser')==null){
            return redirect('dashboard');
            
    }
    else{
        return view('auth.loginuser');
   
    }
    }

    function check(Request $request ){

        $request->validate([
            'user_id'=>'required',
            'initial_password'=>'required',
        ]);

  
        $userInfo = User::where('user_id','=', Str::upper($request->user_id))->first();
        if(!$userInfo){
            return back()->with('fail','We do not recognize your UserName');
        }else{
            $userP = User::where([
                'user_id' => Str::upper($request->user_id), 
                'initial_password' => $request->initial_password
            ])->first();

            if(!$userP){
                return back()->with('fail','We do not recognize your UserName or Password');
            
            // if(HASH::check($request->initial_password, $userInfo->initial_password)){
            // //     $request->session()->put('LoggedUser', $userInfo->user_id);
        //     'user_id' , 
        // 'initial_password',
        // 'employee_id',
        // 'user_group_id',
        // 'company_id',
        // 'user_mobile',

            }else{
                $request->session()->put('LoggedUser', $userInfo->employee_id);
                $request->session()->put('LoggedId', $request->user_id);
                return redirect('dashboard');
            }
        }
    }
//start dashboard
    function dashboard(){
        $uri = Route::getFacadeRoot()->current()->uri();

        if(!session('LoggedUser')==null)
{        try
        {
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

            $header =DB::table('ALL_USER_SUB_DETAILS')
            ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'SUB_MENU_ID', 'SUB_MENU_1', 'SUB_MENU_2', 'SUB_MENU_NAME','ROUTE')
            ->where ('ROUTE','=',$uri)
            ->get();

 $wmpCountData=DB::table(DB::raw('HRM.EMP_PERSONAL Ep'))
 ->select(DB::raw('COUNT(EO.EMPNO) EMPNO'),'EO.DEPT_NAME')
 ->crossJoin(DB::raw('HRM.EMP_OFFICIAL EO'))
 ->whereRaw('EO.EMPNO = Ep.EMPNO')
 ->where('Ep.STATUS','=','Active')
 ->where('EO.COMPANY_ID','=','100')
 ->groupBy('EO.DEPT_NAME')
 ->get();


 $dailyOT=DB::table('ATTD_OT_GROUP_VW')
 ->get();

$dailyAttdSum=DB::table(DB::raw('attendance_details ad'))
->select('EP.SEX',DB::raw('COUNT(eo.empno) total_emp'),DB::raw('(SELECT   
                    COUNT (eo.empno)
               FROM attendance_details ad, emp_official eo, emp_personal ep
              WHERE eo.empno = ad.empno AND ep.empno = eo.empno
             AND AD.ATT_DATE='.'\'08-APR-2023\''.'
              AND eo.company_id='.'\'100\''.'
                         GROUP BY 
      eo.company_id  )T_EMP'))
->crossJoin(DB::raw('emp_official eo'))
->crossJoin(DB::raw('emp_personal ep'))
->whereRaw('eo.empno = ad.empno')
->whereRaw('ep.empno = eo.empno')
->where('AD.ATT_DATE','=','2023-04-08')
->where('eo.company_id','=','100')
->groupBy(['eo.company_id','EP.SEX'])
->get();


 $expusdt="";
 $exportDataarrat=['Month','Quantity'];

 $empCountData="";
 foreach($wmpCountData as $wmpCountData){
    $empCountData .="['".$wmpCountData->dept_name."',".$wmpCountData->empno."],";
 }
 $expusd="";
//  foreach($exportUSD as $expusdt){
//     $expusd .="['".$expusdt->month."',".$expusdt->total_price."],";
//  }
$empOTData="";
foreach($dailyOT as $dailyOT){
    $empOTData .="['".$dailyOT->a_date."',".$dailyOT->c_hour."],";
 }
 $empATTDData="";
 foreach($dailyAttdSum as $dailyAttdSum){
     $empATTDData .="['".$dailyAttdSum->sex."',".$dailyAttdSum->total_emp."],";
  }
 
//dd($empATTDData);

        return view('dashboard',['empATTDData'=>$empATTDData,'empOTData'=>$empOTData,'headeer'=>$header,'data'=>$data,'menu'=>$leftmenu,'empCountData'=>$empCountData,'expusd'=>$expusd,'submenu'=>$submenu,'submenu2'=>$submenu2]);
        }
        catch(Exception $e)
        {
           dd($e->getMessage());
        }}
        else{
            return redirect('login');
        }
    }

//end dashboard






    function logout(){
        if(session()->has('LoggedUser')){
            session()->pull('LoggedUser');
            session()->pull('LoggedId');
            return redirect('login');
        }
    }
     function demo(){
        $exportUSD=DB::table(DB::raw('COM_INVOICE_MASTER M'))
        ->select(DB::raw('TO_CHAR(DELIVERY_DATE,\'fmMonth-RRRR\') MONTH'),DB::raw('SUM((NVL(QUANTITY,0)*UNIT_PRICE))  TOTAL_PRICE'),DB::raw('SUM((NVL(QUANTITY,0)*UNIT_PRICE)*CURRENCY_RATE) TOTAL_PRICE_BDT'))
        ->crossJoin(DB::raw('COM_INVOICE_DETAILS D'))
        ->whereRaw('M.COM_INVOICE_PK = D.COM_INVOICE_PK')
        ->whereBetween('DELIVERY_DATE',[DB::raw('TRUNC(SYSDATE-1,\'YEAR\')'),DB::raw('TRUNC(SYSDATE-1)')])
        ->groupByRaw('TO_CHAR(DELIVERY_DATE,\'fmMonth-RRRR\'), TO_NUMBER(TO_CHAR(DELIVERY_DATE,\'RRRRMM\'))')
        ->orderByRaw('TO_NUMBER(TO_CHAR(DELIVERY_DATE,\'RRRRMM\')) ASC')
        ->get();
dd( $exportUSD);
        return view('common.gatepass',['gatepassdetails'=>$gatepassdetails]);
     }
}
