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
use App\Http\Controllers\Inventory\CategoryController;
use App\Http\Controllers\Inventory\ItemController;
use App\Http\Controllers\Inventory\PurchaseOrderController;
use App\Http\Controllers\Inventory\ItemReceivedController;
use Illuminate\Support\Facades\Auth;


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


Route::get('/check-login', function () {
    return [
        'auth_check' => auth()->check(),
        'user' => auth()->user()
    ];
});
Route::prefix('api')->middleware(['auth'])->group(function () {
    
    // ──── PERSONAL INFORMATION ────
    Route::post('/saveEmpPersonal', [EmpControllers::class, 'saveEmpPersonal']);
    
    // ──── OFFICIAL INFORMATION ────
    Route::post('/saveEmpOfficial', [EmpControllers::class, 'saveEmpOfficial']);
    
    // ──── LOCATION/ADDRESS INFORMATION ────
    Route::post('/saveEmpLocation', [EmpControllers::class, 'saveEmpLocation']);
    
    // ──── EDUCATION/QUALIFICATION ────
    Route::post('/saveEmpQualification', [EmpControllers::class, 'saveEmpQualification']);
    Route::get('/getEmpQualifications/{empno}', [EmpControllers::class, 'getEmpQualifications']);
    
    // ──── SHORT COURSES ────
    Route::post('/saveEmpShortCourse', [EmpControllers::class, 'saveEmpShortCourse']);
    Route::get('/getEmpShortCourses/{empno}', [EmpControllers::class, 'getEmpShortCourses']);
    
    // ──── FAMILY INFORMATION ────
    Route::post('/saveEmpFamily', [EmpControllers::class, 'saveEmpFamily']);
    Route::get('/getEmpFamily/{empno}', [EmpControllers::class, 'getEmpFamily']);
    
    // ──── JOB HISTORY ────
    Route::post('/saveEmpHistory', [EmpControllers::class, 'saveEmpHistory']);
    Route::get('/getEmpHistory/{empno}', [EmpControllers::class, 'getEmpHistory']);
    
    // ──── TRAINING ────
    Route::post('/saveEmpTraining', [EmpControllers::class, 'saveEmpTraining']);
    Route::get('/getEmpTrainings/{empno}', [EmpControllers::class, 'getEmpTrainings']);
    
    // ──── WORK EXPERIENCE ────
    Route::post('/saveEmpWorkExp', [EmpControllers::class, 'saveEmpWorkExp']);
    Route::get('/getEmpWorkExperience/{empno}', [EmpControllers::class, 'getEmpWorkExperience']);
    
    // ──── GET ALL EMPLOYEE DETAILS ────
    Route::get('/getEmpDetails', [EmpControllers::class, 'getEmpDetails']);
    
    // ──── DELETE RECORDS ────
    Route::delete('/deleteEmpRecord/{id}', [EmpControllers::class, 'deleteEmpRecord']);
});





Route::get('/check-login', function () {
    return [
        'auth_check' => auth()->check(),
        'user' => auth()->user()
    ];
});


Route::middleware(['web'])->group(function () {
Route::get('/',[LoginController::class,'login'])->name('login');
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('auth/check', [LoginController::class, 'check'])->name('auth.check');

    Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');

});





//login Page
// Route::get('/',[LoginController::class,'login'])->name('login');
// Route::get('/login',[LoginController::class,'login'])->name('login');

// Route::post('auth/check',[LoginController::class,'check'])->name('auth.check');
Route::get('dashboard',[LoginController::class, 'dashboard'])->name('dashboard');
Route::get('/auth/logout',[LoginController::class, 'logout'])->name('auth.logout');


//report
Route::get('/hrm/report',[ReportController::class, 'hrmreport'])->name('report.hrm')->middleware(['auth']);
Route::get('getReportPera/{id}',[ReportController::class, 'getReportId'])->name('report.hrm');
Route::get('getReportFile/{id}',[ReportController::class, 'getReportFile'])->name('report.hrm');
Route::get('getReportName/{id}',[ReportController::class, 'getReportName'])->name('report.hrm');
Route::get('hrm/pdfReport',[ReportController::class, 'pdfview']);




Route::get('/common/gatepass',[GpController::class, 'gatepass'])->name('common.gatepass')->middleware(['auth']);
//Route::get('/file',[GpController::class, 'getFile'])->name('getFile');



//emp_controller 
Route::get('/empnewentry',[EmpControllers::class,'empentry'])->name('empnewentry')->middleware(['auth']);
// Route::get('/empnewentryfind',[EmpControllers::class,'empnewentryfind']);
Route::get('/empsearch',[EmpControllers::class,'empsearch'])->middleware(['auth']);
Route::get('/empList',[EmpControllers::class,'getAllEmpList'])->middleware(['auth']);

Route::get('/index',[EmpControllers::class,'index']);
Route::post('/emppersonalsave',[EmpControllers::class,'employeePersonalInsert'])->name('employeePersonalInsert')->middleware(['auth']);
Route::post('/empoffcsave',[EmpControllers::class,'employeeOfficialInsert'])->name('employeeOfficalInsert')->middleware(['auth']);
Route::post('/empaddcsave',[EmpControllers::class,'empaddressSave'])->name('empaddressSave')->middleware(['auth']);
Route::post('/empEducsave',[EmpControllers::class,'empeduSave'])->name('empEducsave')->middleware(['auth']);
Route::post('/empShortSave',[EmpControllers::class,'empShortSave'])->name('empEducsave')->middleware(['auth']);
Route::post('/empNomineeSave',[EmpControllers::class,'empNomineeSave'])->name('empEducsave')->middleware(['auth']);
Route::post('/empHistory',[EmpControllers::class,'empHistory'])->name('empHistory')->middleware(['auth']);
Route::post('/empTraining',[EmpControllers::class,'empTraining'])->middleware(['auth']);
Route::post('/empExp',[EmpControllers::class,'empExp'])->middleware(['auth']);
Route::get('/empPerUpdate',[EmpControllers::class,'employeePersonalUpdate'])->middleware(['auth']);
Route::get('/leave',[EmpControllers::class,'leaveentry'])->middleware(['auth']);
Route::get('/getLeaveDetails/{empno}/{year}',[EmpControllers::class,'getLeaveDetails'])->middleware(['auth']);
Route::get('/getPrebal/{empno}/{year}/{lv}',[EmpControllers::class,'getLeavePrebal'])->middleware(['auth']);
Route::get('/getLeavBal/{lv}',[EmpControllers::class,'getLeavBal'])->middleware(['auth']);
Route::get('/LeaveEntry',[EmpControllers::class,'leaveEntryIns'])->middleware(['auth']);
Route::get('/LeaveEntryDet',[EmpControllers::class,'leaveEntryDet'])->middleware(['auth']);
Route::get('/deleteLeave/{empno}/{year}/{lvsl}',[EmpControllers::class,'deleteLeave'])->middleware(['auth']);
Route::get('/empSearchExist',[EmpControllers::class,'empSearchExist'])->middleware(['auth']);



//emp List Route

Route::get('/getDept/{id}',[EmpEntListController::class,'deptList'])->middleware(['auth']);
Route::get('/floorList/{id}',[EmpEntListController::class,'floorList'])->middleware(['auth']);
Route::get('/city',[EmpEntListController::class,'city'])->middleware(['auth']);



Route::get('/getEmp',[EmpEntListController::class,'getEmp'])->middleware(['auth']);
Route::get('/demo',[EmpEntListController::class,'demo'])->middleware(['auth']);
Route::get('/getEdu/{id}',[EmpEntListController::class,'getEdu'])->middleware(['auth']);
Route::get('/getCourse/{id}',[EmpEntListController::class,'getCourse'])->middleware(['auth']);
Route::get('/getNome/{id}',[EmpEntListController::class,'getNome'])->middleware(['auth']);
Route::get('/getJob/{id}',[EmpEntListController::class,'getJob'])->middleware(['auth']);
Route::get('/getTrain/{id}',[EmpEntListController::class,'getTrain'])->middleware(['auth']);
Route::get('/empExper/{id}',[EmpEntListController::class,'empExper'])->middleware(['auth']);


Route::get('/loan',[LoanController::class,'loan'])->middleware(['auth']);
Route::get('/loandt',[LoanController::class,'loandt'])->middleware(['auth']);




Route::post('/loansave',[LoanController::class,'storeer'])->middleware(['auth']);
Route::get('/loandtsave',[LoanController::class,'storeerdetails'])->middleware(['auth']);


Route::get('/getemp/{comid}',[LoanController::class,'getEmpNO'])->middleware(['auth']);
Route::get('/getempdet',[LoanController::class,'getEMPdetails'])->middleware(['auth']);
Route::get('/getinEmp',[EmpControllers::class,'getEmpDet'])->middleware(['auth']);
Route::get('/getprevgross',[EmpControllers::class,'getPrevGross'])->middleware(['auth']);



//ADMIN LIST

Route::get('/menudetails',[AdminController::class,'getAllMenu'])->middleware(['auth']);
Route::get('/getEMPDT',[EmpEntListController::class,'getEMPDT'])->middleware(['auth']);

Route::get('/increment',[EmpControllers::class,'increment_details'])->middleware(['auth']);
Route::get('/incrementEntry',[EmpControllers::class,'increment_Entry'])->middleware(['auth']);
Route::get('/getEmpData', [EmpControllers::class,'empData'])->name('emp.data')->middleware(['auth']);
Route::get('/tableData/{empId}', [EmpControllers::class,'tableData'])->name('t.data')->middleware(['auth']);



//hrm setup

//Designation
Route::get('/des',[HrmSetupController::class,'designation'])->name('des')->middleware(['auth']);
Route::post('/desiinsert',[HrmSetupController::class,'insertDesignation'])->name('insertdata4')->middleware(['auth']);
Route::post('/desUpdate', [HrmSetupController::class, 'editdes'])->name('editdes')->middleware(['auth']);
Route::get('/destroydes/{des_id}',[HrmSetupController::class,'destroydesig'])->name('deletedesig')->middleware(['auth']);

// Department 
Route::get('/dept',[HrmSetupController::class,'department'])->name('dept')->middleware(['auth']);
Route::post('/deptUpdate', [HrmSetupController::class, 'editdept'])->name('editdept')->middleware(['auth']);
Route::post('/deptentry',[HrmSetupController::class,'savedata'])->name('save')->middleware(['auth']);
Route::get('/destroyDept/{grade_id}',[HrmSetupController::class,'destroyDept'])->name('destroy')->middleware(['auth']);

//Company Profile
Route::get('/companypf',[HrmSetupController::class,'companypf'])->middleware(['auth']);
Route::get('/comapnydt',[HrmSetupController::class,'companyDetails'])->middleware(['auth']);
Route::post('/cominsert',[HrmSetupController::class,'companyInsert'])->middleware(['auth']);
Route::post('/comUpdate',[HrmSetupController::class,'companyUpdate'])->middleware(['auth']);
Route::get('/destroyCom/{company_id}',[HrmSetupController::class,'destroyprof'])->name('destroyprofile')->middleware(['auth']);


// Address 
Route::get('/address',[HrmSetupController::class,'address'])->name('address')->middleware(['auth']);
Route::get('/deletecity/{city}',[HrmSetupController::class,'destroyCity'])->name('deletecity')->middleware(['auth']);
Route::get('/deletedistrict/{district}',[HrmSetupController::class,'destroyDistrict'])->name('deletedistrict')->middleware(['auth']);
Route::post('/cityInsert',[HrmSetupController::class,'insertcity'])->name('insertcity')->middleware(['auth']);
Route::post('/districtInsert',[HrmSetupController::class,'insertdistrict'])->name('insertdistrict')->middleware(['auth']);
Route::post('/cityUpdate', [HrmSetupController::class, 'editcity'])->name('editcity')->middleware(['auth']);
Route::post('/districtUpdate', [HrmSetupController::class, 'editdistrict'])->name('editdistrict')->middleware(['auth']);

// line 
Route::get('/line',[HrmSetupController::class,'Line'])->name('line')->middleware(['auth']);
Route::post('/lineinsert',[HrmSetupController::class,'insertLine'])->name('insertdataline')->middleware(['auth']);
Route::post('/lineUpdate',[HrmSetupController::class,'editLine'])->name('updatedataline')->middleware(['auth']);
Route::get('/destroyline/{line_id}',[HrmSetupController::class,'destroyline'])->name('destroydata')->middleware(['auth']);


//Attendence


Route::get('/attend', [AttendanceController::class,'empData'])->name('att.index')->middleware(['auth']);
Route::get('/attendsave',[AttendanceController::class,'store'])->name('att.store')->middleware(['auth']);
Route::get('/attData', [AttendanceController::class,'attendData'])->name('att.data')->middleware(['auth']);
Route::get('/attProcess', [AttendanceController::class,'getAttendenceData'])->name('att.process')->middleware(['auth']);
Route::get('/attDeviceData', [AttendanceController::class,'attddevice'])->name('att.process')->middleware(['auth']);
Route::get('/attDataProcess', [AttendanceController::class,'atdFullProcess'])->name('att.process')->middleware(['auth']);



//SALLARY


Route::get('/salEntry', [SalaryController::class,'companyList'])->middleware(['auth']);
Route::get('/showdata/{companyId}', [SalaryController::class,'showData'])->name('showdata')->middleware(['auth']);
Route::get('/savedata', [SalaryController::class,'storeData'])->middleware(['auth']);
// Route::get('/savedata', [SalaryController::class,'storeData']);
Route::get('/salProcess', [SalProcessController::class,'salProcess'])->middleware(['auth']);
Route::get('/salFullProcess', [SalProcessController::class,'salFullProcess'])->middleware(['auth']);
Route::get('/salProcessDell', [SalProcessController::class,'salProcessDell'])->middleware(['auth']);




//inventory
Route::get('/buyAccList', [InventoryController::class,'buyAccList'])->middleware(['auth']);
Route::post('/storeget', [InventoryController::class,'storeget'])->middleware(['auth']);
Route::post('/storeitmdt', [InventoryController::class,'storeitemdetails'])->middleware(['auth']);
Route::get('/item_gat/{item_id}', [InventoryController::class,'getItemdetails'])->middleware(['auth']);
Route::get('/item_list/{id_pk}', [InventoryController::class,'getItemlist'])->middleware(['auth']);
Route::get('/item_list', [InventoryController::class,'getItemfind'])->middleware(['auth']);
Route::get('/getDetails/{id_pk}', [InventoryController::class,'getItemFull'])->middleware(['auth']);
Route::get('/pdfview/{id_pk}', [InventoryController::class,'pdfview'])->middleware(['auth']);




Route::get('/delete', [InventoryController::class,'getImageName'])->middleware(['auth']);





Route::prefix('inventory')->middleware('web')->group(function () {

    Route::get('/categories', [CategoryController::class,'index']);
    Route::get('/categories/data', [CategoryController::class,'list']);

    Route::get('/groups/list', [CategoryController::class,'groups']); // 🔥

    Route::post('/categories/store', [CategoryController::class,'store']);
    Route::post('/categories/update/{id}', [CategoryController::class,'update']);
    Route::get('/categories/delete/{id}', [CategoryController::class,'destroy']);

});




Route::prefix('inventory/items')->middleware('web')->group(function () {

    Route::get('/', [ItemController::class,'index']);
    Route::get('/data', [ItemController::class,'list']);

    Route::get('/categories', [ItemController::class,'categories']);
    Route::get('/units', [ItemController::class,'units']);

    Route::post('/store', [ItemController::class,'store']);
    Route::post('/update/{id}', [ItemController::class,'update']);
    Route::get('/delete/{id}', [ItemController::class,'destroy']);
});




Route::prefix('purchase-orders')->name('purchase-orders.')->middleware('auth')->group(function () {
 
    // Main CRUD — maps to Forms query/insert/update modes
    Route::get('/',           [PurchaseOrderController::class, 'index'])   ->name('index');
    Route::get('/create',     [PurchaseOrderController::class, 'create'])  ->name('create');
    Route::post('/',          [PurchaseOrderController::class, 'store'])   ->name('store');
    Route::get('/generate-pk', [PurchaseOrderController::class, 'generatePk']);
    Route::get('/generate-po-no', [PurchaseOrderController::class, 'generatePoNo']);
    Route::get('/search', [PurchaseOrderController::class, 'search']);


    Route::get('/{id}',       [PurchaseOrderController::class, 'show'])    ->name('show');
    Route::put('/{id}',       [PurchaseOrderController::class, 'update'])  ->name('update');
    Route::post('delete/{id}',    [PurchaseOrderController::class, 'destroy']) ->name('destroy');
 
    // LOV endpoints — replace Oracle Forms LOV popups
    // WHEN-BUTTON-PRESSED on PO_NUMBER field → PO_LV LOV
    Route::get('/lov/po-numbers',  [PurchaseOrderController::class, 'lovPoNumbers']) ->name('lov.po-numbers');
    // WHEN-BUTTON-PRESSED on ITEM_BTN → ITEMDT LOV
    Route::get('/lov/items',       [PurchaseOrderController::class, 'lovItems'])     ->name('lov.items');
    // Supplier search LOV
    Route::get('/lov/suppliers',   [PurchaseOrderController::class, 'lovSuppliers']) ->name('lov.suppliers');
 
    // Ajax helpers — replace Forms trigger computations
    // WHEN-VALIDATE-ITEM (ITEM_ID) — duplicate check + price lookup
    Route::post('/{id}/validate-item', [PurchaseOrderController::class, 'validateItem']) ->name('validate-item');
    // POST-CHANGE (QUANTITY / ITEM_RATE / PERCENTAGE) — recalculate line totals
    Route::post('/{id}/recalc-line',   [PurchaseOrderController::class, 'recalcLine'])   ->name('recalc-line');
    // WHEN-BUTTON-PRESSED (ITEM_BTN) — bulk import from XL_BIND_UP
    Route::post('/{id}/import-xl',     [PurchaseOrderController::class, 'importXl'])     ->name('import-xl');
 
    // PO Check canvas — WHEN-BUTTON-PRESSED (PUR_ORDER_MASTER.PO_CHECK)
    Route::get('/po-check',    [PurchaseOrderController::class, 'poCheck'])  ->name('po-check');


    Route::get('/{poId}/items', [PurchaseOrderController::class, 'getItemsByPo']);

    Route::get('/generate-pk', [PurchaseOrderController::class, 'generatePk']);
});
 


Route::prefix('item-received')->name('item-received.')->middleware('auth')->group(function () {
    Route::get('/',            [ItemReceivedController::class, 'index'])   ->name('index');
    Route::get('/create',      [ItemReceivedController::class, 'create'])  ->name('create');
    Route::post('/',           [ItemReceivedController::class, 'store'])   ->name('store');
    Route::get('/generate-pk', [ItemReceivedController::class, 'generatePk']);
    Route::get('/{id}/view', [ItemReceivedController::class, 'edit'])->name('view');


    Route::get('/po-full/{pk}', [ItemReceivedController::class, 'getPoFullData']);
    Route::get('/{id}',        [ItemReceivedController::class, 'show'])    ->name('show');
    Route::get('{id}/edit', [ItemReceivedController::class, 'editForm'])->name('edit');
    Route::put('/{id}',        [ItemReceivedController::class, 'update'])  ->name('update');
    Route::delete('/{id}',     [ItemReceivedController::class, 'destroy']) ->name('destroy');

});



Route::prefix('item-received/lov')->middleware('auth')->group(function () {
    Route::get('/items',     [ItemReceivedController::class, 'lovItems']);
    Route::get('/po-by-supplier/{supplierId}', [ItemReceivedController::class, 'getPoBySupplier']);
    Route::get('/suppliers', [ItemReceivedController::class, 'lovSuppliers']);
    Route::get('/po-numbers',[ItemReceivedController::class, 'lovPo']);
});


