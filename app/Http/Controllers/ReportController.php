<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Session;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route ;


class ReportController extends Controller
{
   
    

function hrmreport(){



 //   $uri = Route::getFacadeRoot()->current()->uri();
    $uri = '';

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
        $getCompanyDetails = DB::table('COMPANY')
        ->get();

    // dd($getCompanyDetails);
    $getCompany = DB::table('COMPANY')
        ->select('COMPANY_ID', 'COMPANY_NAME')
        ->get();
    //return json_encode($deptList);
    //        dd($ll)
    $reportLits=DB::table(DB::raw('HRM_REPORT hr'))
    ->distinct()
    ->select('hr.REPORT_ID','REPORT_TITLE','REPORT_FILE_NAME')
    ->crossJoin(DB::raw('HRM_REPORT_PARAMETER hrp'))
    ->where('MODULE','=','1')
    ->get();

    return view('report.hrmreport', ['reportLits'=>$reportLits,'getCompanyDetails' => $getCompanyDetails, 'data' => $data, 'getCompany' => $getCompany, 'menu' => $leftmenu, 'submenu' => $submenu, 'headeer' => $headeer, 'submenu2' => $submenu2, 'empnoList' => $empnoList]);


}


function getReportId($id){
  $reportFile=DB::table(DB::raw('HRM_REPORT hr'))
  ->distinct()
  ->select('hr.REPORT_ID','REPORT_TITLE','PARAMETER_NAME','REPORT_FILE_NAME')
  ->crossJoin(DB::raw('HRM_REPORT_PARAMETER hrp'))
  ->whereRaw('hr.REPORT_ID = hrp.REPORT_ID')
  ->where('HR.MODULE','=','1')
  ->where('HR.REPORT_ID','=',$id)
  ->get();
   return $reportFile;
}
function getReportFile($id){
    $reportFile=DB::table(DB::raw('HRM_REPORT hr'))
    ->distinct()
    ->select('hr.REPORT_ID','REPORT_FILE_NAME')
    ->where('HR.MODULE','=','1')
    ->where('HR.REPORT_ID','=',$id)
    ->get();
     return $reportFile;
  }
  function getReportName($id){
    $reportFile=DB::table(DB::raw('HRM_REPORT hr'))
    ->distinct()
    ->select('JS_REPORT')
    ->where('HR.MODULE','=','1')
    ->where('HR.REPORT_ID','=',$id)
    ->first();
     return $reportFile;
  }



  public function pdfview(Request $request){
    // dd($link);


    $queryString = $request->getQueryString(); // Get the query string portion of the URL
    
    $queryString = $request->getQueryString();
    //echo $queryString;
        $link='http://192.168.189.205:8080/jri/report?_repFormat=pdf&_dataSource=default&'.$queryString;

       // dd($link);




    return view('report.pdf',compact('link'));
   
   }









}
