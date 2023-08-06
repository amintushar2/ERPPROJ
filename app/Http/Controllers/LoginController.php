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

 $exportData="";
 $exportUSD="";

 $exportDataarrat=['Month','Quantity'];

 $expdta="";
//  foreach($exportData as $expdt){
//     $expdta .="['".$expdt->month."',".$expdt->qtuanty."],";
//  }
 $expusd="";
//  foreach($exportUSD as $expusdt){
//     $expusd .="['".$expusdt->month."',".$expusdt->total_price."],";
//  }

        return view('dashboard',['headeer'=>$header,'data'=>$data,'menu'=>$leftmenu,'expdta'=>$expdta,'expusd'=>$expusd,'submenu'=>$submenu,'submenu2'=>$submenu2]);
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
