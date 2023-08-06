<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Route ;

use App\Models\SalaryModel;

class SalaryController extends Controller
{
    

    public function companyList(){
        $comName = DB::table('COMPANY_PROFILE')
        ->select('COMPANY_ID','COMPANY_NAME')
        ->orderBy('COMPANY_ID','asc')
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
        return view('salary.salary',['compList'=>$comName,'data'=>$data,'getCompany'=>$getCompany,'menu'=>$leftmenu,'submenu'=>$submenu ,'headeer'=>$headeer,'submenu2'=>$submenu2,'empnoList'=>$empnoList]);
    }

    public function storeData(Request $request)
    {
        $companyId= $request->get('company_id');
        $paydate= $request->get('sal_date');
        try {
            $delete=DB::table('emp_payment')
            // ->where('company_id','=',$companyId)
            ->delete();


            if($delete==0||$delete>0)
            {
                try{
                $getData[]= DB::table(DB::raw('emp_personal ep'))
                ->distinct()
                ->select(['ep.empno','ep.new_empno',DB::raw('ep.first_name||\'  \'||ep.middle_name||\'  \'||ep.last_name ename'),'eo.des_name','eo.gross','eo.hr','eo.tax_deduction',DB::raw('ROUND((eo.gross-(600+900+350))/1.5,0) BASIC'),DB::raw('ROUND(((eo.gross-(600+900+350))/1.5)/2,0) HOUSE_RENT'),DB::raw('\'600\' MEDICAL'),
                DB::raw('\'900\' FOOD'),DB::raw('\'350\' CONVANCE'),DB::raw('replace(eo.grade_id,\'Grade-\',null) grade')])
                ->crossJoin(DB::raw('emp_official eo'))
                ->crossJoin(DB::raw('attendance_details ad'))
                ->whereRaw('ep.empno = eo.empno')
                ->whereRaw('ep.empno = ad.empno')
                ->where('ep.company_id','=',$companyId)
                ->whereBetween('AD.ATT_DATE',[DB::raw('trunc(TO_DATE(\''.$paydate.'\',\'YYYY-MM-DD\'),\'MM\')'),DB::raw('last_day(TO_DATE(\''.$paydate.'\',\'YYYY-MM-DD\'))')])
                ->whereRaw('nvl(eo.gross,0) > ? ', [0])
                ->orderByRaw('1 ASC')
        
                ->get()->toArray();

                if($getData>0){
                    foreach($getData as $getData){
                        $count_emp = count($getData);
        
                        //  return ($count_emp);
                        for($i = 0; $i<$count_emp; $i++)
                        {
                            //   return   $getData[$i];
        
                            try{
                                $data = new SalaryModel;
                                $data->empno= $getData[$i]->empno;
                                $data->new_empno = $getData[$i]->new_empno;
                                $data->des_name= $getData[$i]->des_name;
                                $data->gross = $getData[$i]->gross;
                                $data->basic= $getData[$i]->basic;
                                $data->hr_amt= $getData[$i]->house_rent;
                                $data->mr_amt= $getData[$i]->medical;
                                $data->convance = $getData[$i]->convance;     
                                $data->food_allowance = $getData[$i]->food;
                                $data->tax= $getData[$i]->tax_deduction;
                                $data->emp_grade= $getData[$i]->grade;
                                $data->company_id= $companyId;
                    
                                $data->save();
                               
                            }catch(\Illuminate\Database\QueryException $e){
                      
                                return $e;
                            } 

                        } 
          return response()->json([
                                    'status2' => 200                            
                                ], 200);
           
                    }

                }

            }catch(\Illuminate\Database\QueryException $e){
                return $e;
      
            } 

            
        }else{
    }
    }catch(\Illuminate\Database\QueryException $e){
        return $e;
            
            } 
    //     } 
        // $arr=json_decode($getData);


       // return ($getData);
       
    }

    public function showData($companyId)
    {
       
try{
        $salData = DB::table('EMP_PAYMENT')
       ->select('EMPNO',DB::RAW('HRM.GET_EMP_NAME(EMPNO) EMP_NAME'),'NEW_EMPNO','DES_NAME','GROSS','BASIC','HR_AMT','CONVANCE','FOOD_ALLOWANCE','TAX','EMP_GRADE','STAMP')
       ->where('COMPANY_ID','=',$companyId)
       ->orderBy('EMPNO','asc')
       ->get();

    }catch(\Illuminate\Database\QueryException $e){
        return $e;

    } 
       return view('salary.sal_table',['salaryList'=>$salData]);
    }
}
