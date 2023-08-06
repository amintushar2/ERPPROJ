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
Route::get('/common/gatepass',[GpController::class, 'gatepass'])->name('common.gatepass');
//Route::get('/file',[GpController::class, 'getFile'])->name('getFile');

//emp_controller 
Route::get('/empnewentry',[EmpControllers::class,'empentry'])->name('empnewentry');
Route::get('/empnewentryfind',[EmpControllers::class,'empnewentryfind']);
Route::get('/empsearch',[EmpControllers::class,'empsearch']);
Route::get('/empList',[EmpControllers::class,'getAllEmpList']);

Route::get('/index',[EmpControllers::class,'index']);
Route::post('/emppersonalsave',[EmpControllers::class,'employeePersonalInsert'])->name('employeePersonalInsert');
Route::post('/empoffcsave',[EmpControllers::class,'employeeOfficialInsert'])->name('employeeOfficalInsert');
Route::post('/empaddcsave',[EmpControllers::class,'empaddressSave'])->name('empaddressSave');
Route::post('/empEducsave',[EmpControllers::class,'empeduSave'])->name('empEducsave');
Route::post('/empShortSave',[EmpControllers::class,'empShortSave'])->name('empEducsave');
Route::post('/empNomineeSave',[EmpControllers::class,'empNomineeSave'])->name('empEducsave');
Route::post('/empHistory',[EmpControllers::class,'empHistory'])->name('empHistory');
Route::post('/empTraining',[EmpControllers::class,'empTraining'])->name('empHistory');
Route::post('/empExp',[EmpControllers::class,'empExp'])->name('empHistory');



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


Route::get('/des',[HrmSetupController::class,'designation'])->name('des');
Route::post('/desiinsert',[HrmSetupController::class,'insertDesignation'])->name('insertdata4');
Route::post('/desUpdate', [HrmSetupController::class, 'editdes'])->name('editdes');
Route::get('/destroydes/{des_id}',[HrmSetupController::class,'destroydesig'])->name('deletedesig');
// Department 
Route::get('/dept',[HrmSetupController::class,'department'])->name('dept');
Route::post('/deptUpdate', [HrmSetupController::class, 'editdept'])->name('editdept');
Route::post('/deptentry',[HrmSetupController::class,'savedata'])->name('save');
Route::get('/destroy/{grade_id}',[HrmSetupController::class,'destroy'])->name('destroy');
//Company Profile
Route::get('/companypf',[HrmSetupController::class,'companypf']);
Route::get('/comapnydt',[HrmSetupController::class,'companyDetails']);
Route::post('/cominsert',[HrmSetupController::class,'companyInsert']);
Route::post('/comUpdate',[HrmSetupController::class,'companyUpdate']);


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
