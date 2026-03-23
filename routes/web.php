<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\GpController;
use App\Http\Controllers\EmpControllers;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmpEntListController;
use App\Http\Controllers\LoanController;
use App\Http\controllers\HrmSetupController;

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\SalProcessController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\InventoryController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

//Route::get('/',[LoginController::class,'demo'])->name('login');

Route::get('/checkdb',[LoginController::class,'checkdb'])->name('checkdb');

//login Page
Route::get('/',[LoginController::class,'login'])->name('login');
Route::get('/login',[LoginController::class,'login'])->name('login');

Route::post('auth/check',[LoginController::class,'check'])->name('auth.check');
Route::get('dashboard',[LoginController::class, 'dashboard'])->name('dashboard');
Route::get('/auth/logout',[LoginController::class, 'logout'])->name('auth.logout');


//report
Route::get('/hrm/report',[ReportController::class, 'hrmreport'])->name('report.hrm');
Route::get('getReportPera/{id}',[ReportController::class, 'getReportId'])->name('report.hrm');
Route::get('getReportFile/{id}',[ReportController::class, 'getReportFile'])->name('report.hrm');
Route::get('getReportName/{id}',[ReportController::class, 'getReportName'])->name('report.hrm');
Route::get('hrm/pdfReport',[ReportController::class, 'pdfview']);




Route::get('/common/gatepass',[GpController::class, 'gatepass'])->name('common.gatepass');
//Route::get('/file',[GpController::class, 'getFile'])->name('getFile');



//emp_controller 
Route::get('/empnewentry',[EmpControllers::class,'empentry'])->name('empnewentry');
// Route::get('/empnewentryfind',[EmpControllers::class,'empnewentryfind']);
Route::get('/empsearch',[EmpControllers::class,'empsearch']);
Route::get('/empList',[EmpControllers::class,'getAllEmpList']);
Route::get('/empDetailsSearch',[EmpControllers::class,'getEmpDetSearch']);

Route::get('/index',[EmpControllers::class,'index']);
Route::post('/emppersonalsave',[EmpControllers::class,'employeePersonalInsert'])->name('employeePersonalInsert');
Route::post('/empoffcsave',[EmpControllers::class,'employeeOfficialInsert'])->name('employeeOfficalInsert');
Route::post('/empaddcsave',[EmpControllers::class,'empaddressSave'])->name('empaddressSave');
Route::post('/empEducsave',[EmpControllers::class,'empeduSave'])->name('empEducsave');
Route::post('/empShortSave',[EmpControllers::class,'empShortSave'])->name('empEducsave');
Route::post('/empNomineeSave',[EmpControllers::class,'empNomineeSave'])->name('empEducsave');
Route::post('/empHistory',[EmpControllers::class,'empHistory'])->name('empHistory');
Route::post('/empTraining',[EmpControllers::class,'empTraining']);
Route::post('/empExp',[EmpControllers::class,'empExp']);
Route::get('/empPerUpdate',[EmpControllers::class,'employeePersonalUpdate']);
Route::get('/leave',[EmpControllers::class,'leaveentry']);
Route::get('/getLeaveDetails/{empno}/{year}',[EmpControllers::class,'getLeaveDetails']);
Route::get('/getPrebal/{empno}/{year}/{lv}',[EmpControllers::class,'getLeavePrebal']);
Route::get('/getLeavBal/{lv}',[EmpControllers::class,'getLeavBal']);
Route::get('/LeaveEntry',[EmpControllers::class,'leaveEntryIns']);
Route::get('/LeaveEntryDet',[EmpControllers::class,'leaveEntryDet']);
Route::get('/deleteLeave/{empno}/{year}/{lvsl}',[EmpControllers::class,'deleteLeave']);
Route::get('/empSearchExist',[EmpControllers::class,'empSearchExist']);



//emp List Route

Route::get('/getDept/{id}',[EmpEntListController::class,'deptList']);
Route::get('/floorList/{id}',[EmpEntListController::class,'floorList']);
Route::get('/city',[EmpEntListController::class,'city']);



Route::get('/getEmp',[EmpEntListController::class,'getEmp']);
Route::get('/demo',[EmpEntListController::class,'demo']);
Route::get('/getEdu/{id}',[EmpEntListController::class,'getEdu']);
Route::get('/getCourse/{id}',[EmpEntListController::class,'getCourse']);
Route::get('/getNome/{id}',[EmpEntListController::class,'getNome']);
Route::get('/getJob/{id}',[EmpEntListController::class,'getJob']);
Route::get('/getTrain/{id}',[EmpEntListController::class,'getTrain']);
Route::get('/empExper/{id}',[EmpEntListController::class,'empExper']);


Route::get('/loan',[LoanController::class,'loan']);
Route::get('/loandt',[LoanController::class,'loandt']);




Route::post('/loansave',[LoanController::class,'storeer']);
Route::get('/loandtsave',[LoanController::class,'storeerdetails']);


Route::get('/getemp/{comid}',[LoanController::class,'getEmpNO']);
Route::get('/getempdet',[LoanController::class,'getEMPdetails']);
Route::get('/getinEmp',[EmpControllers::class,'getEmpDet']);
Route::get('/getprevgross',[EmpControllers::class,'getPrevGross']);



//ADMIN LIST

Route::get('/menudetails',[AdminController::class,'getAllMenu']);
Route::get('/getEMPDT',[EmpEntListController::class,'getEMPDT']);

Route::get('/increment',[EmpControllers::class,'increment_details']);
Route::get('/incrementEntry',[EmpControllers::class,'increment_Entry']);
Route::get('/getEmpData', [EmpControllers::class,'empData'])->name('emp.data');
Route::get('/tableData/{empId}', [EmpControllers::class,'tableData'])->name('t.data');



//hrm setup

//Designation
Route::get('/des',[HrmSetupController::class,'designation'])->name('des');
Route::post('/desiinsert',[HrmSetupController::class,'insertDesignation'])->name('insertdata4');
Route::post('/desUpdate', [HrmSetupController::class, 'editdes'])->name('editdes');
Route::get('/destroydes/{des_id}',[HrmSetupController::class,'destroydesig'])->name('deletedesig');

// Department 
Route::get('/dept',[HrmSetupController::class,'department'])->name('dept');
Route::post('/deptUpdate', [HrmSetupController::class, 'editdept'])->name('editdept');
Route::post('/deptentry',[HrmSetupController::class,'savedata'])->name('save');
Route::get('/destroyDept/{grade_id}',[HrmSetupController::class,'destroyDept'])->name('destroy');

//Company Profile
Route::get('/companypf',[HrmSetupController::class,'companypf']);
Route::get('/comapnydt',[HrmSetupController::class,'companyDetails']);
Route::post('/cominsert',[HrmSetupController::class,'companyInsert']);
Route::post('/comUpdate',[HrmSetupController::class,'companyUpdate']);
Route::get('/destroyCom/{company_id}',[HrmSetupController::class,'destroyprof'])->name('destroyprofile');


// Address 
Route::get('/address',[HrmSetupController::class,'address'])->name('address');
Route::get('/deletecity/{city}',[HrmSetupController::class,'destroyCity'])->name('deletecity');
Route::get('/deletedistrict/{district}',[HrmSetupController::class,'destroyDistrict'])->name('deletedistrict');
Route::post('/cityInsert',[HrmSetupController::class,'insertcity'])->name('insertcity');
Route::post('/districtInsert',[HrmSetupController::class,'insertdistrict'])->name('insertdistrict');
Route::post('/cityUpdate', [HrmSetupController::class, 'editcity'])->name('editcity');
Route::post('/districtUpdate', [HrmSetupController::class, 'editdistrict'])->name('editdistrict');

// line 
Route::get('/line',[HrmSetupController::class,'Line'])->name('line');
Route::post('/lineinsert',[HrmSetupController::class,'insertLine'])->name('insertdataline');
Route::post('/lineUpdate',[HrmSetupController::class,'editLine'])->name('updatedataline');
Route::get('/destroyline/{line_id}',[HrmSetupController::class,'destroyline'])->name('destroydata');


//Attendence


Route::get('/attend', [AttendanceController::class,'empData'])->name('att.index');
Route::get('/attendsave',[AttendanceController::class,'store'])->name('att.store');
Route::get('/attData', [AttendanceController::class,'attendData'])->name('att.data');
Route::get('/attProcess', [AttendanceController::class,'getAttendenceData'])->name('att.process');
Route::get('/attDeviceData', [AttendanceController::class,'attddevice'])->name('att.process');
Route::get('/attDataProcess', [AttendanceController::class,'atdFullProcess'])->name('att.process');



//SALLARY


Route::get('/salEntry', [SalaryController::class,'companyList']);
Route::get('/showdata/{companyId}', [SalaryController::class,'showData'])->name('showdata');
Route::get('/savedata', [SalaryController::class,'storeData']);
// Route::get('/savedata', [SalaryController::class,'storeData']);
Route::get('/salProcess', [SalProcessController::class,'salProcess']);
Route::get('/salFullProcess', [SalProcessController::class,'salFullProcess']);
Route::get('/salProcessDell', [SalProcessController::class,'salProcessDell']);




//inventory
Route::get('/buyAccList', [InventoryController::class,'buyAccList']);
Route::post('/storeget', [InventoryController::class,'storeget']);
Route::post('/storeitmdt', [InventoryController::class,'storeitemdetails']);
Route::get('/item_gat/{item_id}', [InventoryController::class,'getItemdetails']);
Route::get('/item_list/{id_pk}', [InventoryController::class,'getItemlist']);
Route::get('/item_list', [InventoryController::class,'getItemfind']);
Route::get('/getDetails/{id_pk}', [InventoryController::class,'getItemFull']);
Route::get('/pdfview/{id_pk}', [InventoryController::class,'pdfview']);




Route::get('/delete', [InventoryController::class,'getImageName']);