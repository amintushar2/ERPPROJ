<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GGatepassMaster;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use DB;


class GpController extends Controller
{

    function gatepass(){
  
   if (!session('LoggedUser') == null) {
                 $uri = Route::getFacadeRoot()->current()->uri(); 
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
                   
                return view('common.gatepass', ['data' => $data, 'menu' => $leftmenu, 'submenu' => $submenu, 'submenu2' => $submenu2, 'headeer' => $headeer, 'companyList' => $companyList]);
            } catch (Exception $e) {
                dd($e->getMessage());
            }} else {
            return redirect('login');
        }



    
        if(!session('LoggedUser')==null)
        {        

    return view('common.gatepass',['db'=>$db]);

    

}else{
   
        return redirect('login');
    
}
    }


    public function  getFile(){
return Storage::disk('ftp')->directories();

    }
}