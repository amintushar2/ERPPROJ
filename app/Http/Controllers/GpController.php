<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GGatepassMaster;

use Illuminate\Support\Str;
use DB;


class GpController extends Controller
{

    function gatepass(){

    $db=DB::table('COMPANY_PROFILE')
    ->select('COMPANY_NAME', 'COMPANY_ID')
    ->whereIn('COMPANY_ID',(function ($query) {
        $query->from('COMPANY_PERMISSION')
            ->select('COMPANY_ID')
            ->whereIn('USER_GROUP_ID',(function ($query) {
                $query->from('USER_PERMISSION')
                    ->crossJoin('AUTH_GROUP')
                    ->select('USER_PERMISSION.USER_GROUP_ID')
                    ->where(1,'=',1)
                    ->where('AUTH_GROUP.USER_GROUP_ID','=',DB::raw('USER_PERMISSION.USER_GROUP_ID'))
                    ->where('USER_ID','=','AMIN')
                    ->where('AUTH_GROUP.GROUP_TYEP','=','U');
            }));
    }))
    ->get();

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