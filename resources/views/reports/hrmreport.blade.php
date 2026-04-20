<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- {{-- font awesome cdn --}} -->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- {{-- font awesome cdn --}} -->
    <link rel="stylesheet" href="{{URL::asset('plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="/erpcss/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap CSS -->
    <link href="/erpcss/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="/mainjs/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/erpcss/bootstrap.min.css">
    <link rel="stylesheet" href="/erpcss/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="/erpcss/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="/bootstrap_icon/bootstrap-icons.min.css">
    <script src="/mainjs/adminlte.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
    #ui-datepicker-div {}
    </style>
<style type="text/css">
    .text-style:hover {
        text-decoration: underline;
    }
    label {
        font-size: 10px;
    }
    #ui-datepicker-div {
        display: none;
    }
    .select2-selection__rendered {
        line-height: 28px !important;
    }
    .select2-container .select2-selection--single {
        height: 38px !important;
    }
    .select2-selection__arrow {
        height: 35px !important;
    }

    .select2.select2-container {
    width: 100% !important;
}
    @media only screen and (max-width: 400px) {
        body {
            font-size: 50px;
        }
    }
    </style>
    <title>HRM REPORT</title>

    <style>
    .scroll-bar {
        height: 100px;
        width: 900px;
        overflow: auto;
    }
    </style>

</head>

<body>
    @section('title', 'Page Title')
    @include('topbar.sidebar')
    <!-- {{-- <div class=" p-3"> --}} -->
    <div class="container-fluid"id="">
        <div class="content-wrapper"id="">



            <form action="" method="" id="report">
                <div class="container col-lg-6 p-3" id="">
                    <h3 class="text-center">Salary Entry for Employee</h3>
                    <div class="mb-3 row"id="">
                        <label for="company_name" class="col-sm-3 col-form-label">Company Name : </label>
                        <div class="col-sm-8"id="div1">
                            <select class="form-select" id="report_list">
                            <option value="">Select Report</option>

                                @foreach($reportLits as $reportLits)
                                <option value="{{ $reportLits->report_id }}">{{ $reportLits->report_title }}</option>
                                @endforeach
                            </select>
                            <input type="text" class="form-control" name="_repName" id="repoName" placeholder=""
                                value="{{ old('_repName') }}" hidden>
                        </div>
                    </div>

                    <hr />
                    {{-- Leave Catogory input --}}
                    <div class="mb-3 row" id="P_COMPANY_div">
                        <label for="company_name" class="col-sm-3 col-form-label ">Company Name : </label>
                        <div class="col-sm-8">
                            <select class="form-select" id="P_COMPANY" name="P_COMPANY">
                                @foreach($getCompanyDetails as $company)
                                <option value="{{ $company->company_id }}">{{ $company->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Remarks input --}}
                    <div class="mb-3 row container" id="P_EMP_TYPE_div">
                        <label for="sal_date" class="col-sm-3 col-form-label ">EMP TYPE : </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="P_EMP_TYPE" id="P_EMP_TYPE" placeholder=""
                                value="{{ old('sal_date') }}">
                        </div>
                    </div>

                    {{-- section --}}
                    <div class="mb-3 row container"id="P_SECTION_NO_div">
                        <label for="sal_date" class="col-sm-3 col-form-label ">SECTION  : </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="P_SECTION_NO" id="P_SECTION_NO" placeholder=""
                                value="{{ old('P_SECTION_NO') }}">
                        </div>
                    </div>

                    {{-- deptartment --}}
                    <div class="mb-3 row container"id="P_DEPT_NO_div">
                        <label for="P_DEPT_NO" class="col-sm-3 col-form-label ">Department  : </label>
                        <div class="col-sm-8">
                            <select class="form-select" id="P_DEPT_NO" name="P_DEPT_NO">
                                
                            </select>
                        </div>
                    </div>

                    {{-- floor id --}}
                    <div class="mb-3 row container"id="P_FLOOR_ID_div">
                        <label for="P_FLOOR_ID" class="col-sm-3 col-form-label ">Floor  : </label>
                        <div class="col-sm-8">
                            <select class="form-select" id="P_FLOOR_ID" name="P_FLOOR_ID">
                                
                            </select>
                        </div>
                    </div>

                    {{-- increment type --}}
                    <div class="mb-3 row container"id="P_INCREMENT_TYPE_div">
                        <label for="P_INCREMENT_TYPE" class="col-sm-3 col-form-label ">Increment Type  : </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="P_INCREMENT_TYPE" id="P_INCREMENT_TYPE" placeholder=""
                                value="{{ old('P_INCREMENT_TYPE') }}">
                        </div>
                    </div>

                    {{-- payment date --}}
                    <div class="mb-3 row container"id="P_PAYMENT_DATE_div">
                        <label for="P_PAYMENT_DATE" class="col-sm-3 col-form-label ">Payment Date  : </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="P_PAYMENT_DATE" id="P_PAYMENT_DATE" placeholder=""
                                value="{{ old('P_PAYMENT_DATE') }}">
                        </div>
                    </div>

                    {{-- print date --}}
                    <div class="mb-3 row container"id="P_PRINT_DATE_div">
                        <label for="P_PRINT_DATE" class="col-sm-3 col-form-label ">Print Date  : </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="P_PRINT_DATE" id="P_PRINT_DATE" placeholder=""
                                value="{{ old('P_PRINT_DATE') }}">
                        </div>
                    </div>

                    {{-- p date --}}
                    <div class="mb-3 row container"id="P_DATE_div">
                        <label for="P_DATE" class="col-sm-3 col-form-label ">Date  : </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="P_DATE" id="P_DATE" placeholder=""
                                value="{{ old('P_DATE') }}">
                        </div>
                    </div>

                    {{-- Bonus --}}
                    <div class="mb-3 row container"id="P_BNOUS_div">
                        <label for="P_BNOUS" class="col-sm-3 col-form-label ">Bonus  : </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="P_BNOUS" id="P_BNOUS" placeholder=""
                                value="{{ old('P_BNOUS') }}">
                        </div>
                    </div>

                    {{-- status --}}
                    <div class="mb-3 row container"id="P_STATUS_div">
                        <label for="P_STATUS" class="col-sm-3 col-form-label ">Status  : </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="P_STATUS" id="P_STATUS" placeholder=""
                                value="{{ old('P_STATUS') }}">
                        </div>
                    </div>

                    {{-- p days --}}
                    <div class="mb-3 row container"id="P_DAYES_div">
                        <label for="P_DAYES" class="col-sm-3 col-form-label ">Dayes  : </label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="P_DAYES" id="P_DAYES" placeholder=""
                                value="{{ old('P_DAYES') }}">
                        </div>
                    </div>

                    {{-- p month --}}
                    <div class="mb-3 row container"id="P_MONTH_div">
                        <label for="P_MONTH" class="col-sm-3 col-form-label ">Month  : </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="P_MONTH" id="P_MONTH" placeholder=""
                                value="{{ old('P_MONTH') }}">
                        </div>
                    </div>

                    {{-- from date --}}
                    <div class="mb-3 row container"id="P_FROM_DATE_div">
                        <label for="P_FROM_DATE" class="col-sm-3 col-form-label ">From Date  : </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="P_FROM_DATE" id="P_FROM_DATE" placeholder=""
                                value="{{ old('P_FROM_DATE') }}">
                        </div>
                    </div>

                    {{-- to date --}}
                    <div class="mb-3 row container" id="P_TO_DATE_div">
                        <label for="P_TO_DATE" class="col-sm-3 col-form-label ">To Date : </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="P_TO_DATE" id="P_TO_DATE" placeholder=""
                                value="{{ old('P_TO_DATE') }}">
                        </div>
                    </div>

                    {{-- As on --}}
                    <div class="mb-3 row container"id="P_AS_ON_div">
                        <label for="P_AS_ON" class="col-sm-3 col-form-label ">As On  : </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="P_AS_ON" id="P_AS_ON" placeholder=""
                                value="{{ old('P_AS_ON') }}">
                        </div>
                    </div>

                    {{-- attendance date --}}
                    <div class="mb-3 row container"id="P_ATT_DATE_div">
                        <label for="P_ATT_DATE" class="col-sm-3 col-form-label ">Att. Date  : </label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" name="P_ATT_DATE" id="P_ATT_DATE" placeholder=""
                                value="{{ old('P_ATT_DATE') }}">
                        </div>
                    </div>

                    {{-- Employee no --}}
                    <div class="mb-3 row container"id="P_EMP_NO_div">
                        <label for="P_EMP_NO" class="col-sm-3 col-form-label ">Employee No  : </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="P_EMP_NO" id="P_EMP_NO" placeholder=""
                                value="{{ old('P_EMP_NO') }}">
                        </div>
                    </div>

                    {{-- idesignation no --}}
                    <div class="mb-3 row container"id="P_DES_NO_div">
                        <label for="P_DES_NO" class="col-sm-3 col-form-label ">Des No.  : </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="P_DES_NO" id="P_DES_NO" placeholder=""
                                value="{{ old('P_DES_NO') }}">
                        </div>
                    </div>

                    {{-- Work Ent --}}
                    <div class="mb-3 row container"id="P_WRK_ENT_div">
                        <label for="P_WRK_ENT" class="col-sm-3 col-form-label ">Work Ent.  : </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="P_WRK_ENT" id="P_WRK_ENT" placeholder=""
                                value="{{ old('P_WRK_ENT') }}">
                        </div>
                    </div>

                    {{-- Year --}}
                    <div class="mb-3 row container"id="P_YEAR_div">
                        <label for="P_YEAR" class="col-sm-3 col-form-label ">Year  : </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="P_YEAR" id="P_YEAR" placeholder=""
                                value="{{ old('P_YEAR') }}">
                        </div>
                    </div>

                    {{-- Grade --}}
                    <div class="mb-3 row container"id="P_GRADE_div">
                        <label for="P_GRADE" class="col-sm-3 col-form-label ">Grade  : </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="P_GRADE" id="P_GRADE" placeholder=""
                                value="{{ old('P_GRADE') }}">
                        </div>
                    </div>

                    {{-- Religion --}}
                    <div class="mb-3 row container"id="P_RELIGION_div">
                        <label for="P_RELIGION" class="col-sm-3 col-form-label ">Religion : </label>
                        <div class="col-sm-8">
                            <select class="form-select" id="P_RELIGION" name="P_RELIGION">
                                
                            </select>
                        </div>
                    </div>

                    {{-- Blood Group --}}
                    <div class="mb-3 row container"id="P_BLOOD_GROUP_div">
                        <label for="P_BLOOD_GROUP" class="col-sm-3 col-form-label ">Blood Group : </label>
                        <div class="col-sm-8">
                            <select class="form-select" id="P_BLOOD_GROUP" name="P_BLOOD_GROUP">
                                
                            </select>
                        </div>
                    </div>

                    {{-- Sex --}}
                    <div class="mb-3 row container"id="P_SEX_div">
                        <label for="P_SEX" class="col-sm-3 col-form-label ">Sex : </label>
                        <div class="col-sm-8">
                            <select class="form-select" id="P_SEX" name="P_SEX">
                                
                            </select>
                        </div>
                    </div>

                    {{-- Shift code --}}
                    <div class="mb-3 row container"id="P_SHIFT_CODE_div">
                        <label for="P_SHIFT_CODE" class="col-sm-3 col-form-label ">Shift Code : </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="P_SHIFT_CODE" id="P_SHIFT_CODE" placeholder=""
                                value="{{ old('P_SHIFT_CODE') }}">
                        </div>
                    </div>

                    {{-- bank salary --}}
                    <div class="mb-3 row container"id="P_BANK_SAL_div">
                        <label for="P_BANK_SAL" class="col-sm-3 col-form-label ">Bank Sal. : </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="P_BANK_SAL" id="P_BANK_SAL" placeholder=""
                                value="{{ old('P_BANK_SAL') }}">
                        </div>
                    </div>

                    {{-- Line --}}
                    <div class="mb-3 row container"id="P_LINE_div">
                        <label for="P_LINE" class="col-sm-3 col-form-label ">Line  : </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="P_LINE" id="P_LINE" placeholder=""
                                value="{{ old('P_LINE') }}">
                        </div>
                    </div>

                    {{-- Bank name --}}
                    <div class="mb-3 row container"id="P_BANK_NAME_div">
                        <label for="P_BANK_NAME" class="col-sm-3 col-form-label ">Bank Name : </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="P_BANK_NAME" id="P_BANK_NAME" placeholder=""
                                value="{{ old('P_BANK_NAME') }}">
                        </div>
                    </div>

                    {{-- Bill --}}
                    <div class="mb-3 row container"id="P_BILL_div">
                        <label for="P_BILL" class="col-sm-3 col-form-label ">Bill : </label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="P_BILL" id="P_BILL" placeholder=""
                                value="{{ old('P_BILL') }}">
                        </div>
                    </div>

                    {{-- Late deduct --}}
                    <div class="mb-3 row container"id="P_LATE_DEDUCT_div">
                        <label for="P_LATE_DEDUCT" class="col-sm-3 col-form-label ">Late Deduct : </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="P_LATE_DEDUCT" id="P_LATE_DEDUCT" placeholder=""
                                value="{{ old('P_LATE_DEDUCT') }}">
                        </div>
                    </div>

                    {{-- Letter No.--}}
                    <div class="mb-3 row container"id="P_LETTER_NO_div">
                        <label for="P_LETTER_NO" class="col-sm-3 col-form-label ">Letter No. : </label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="P_LETTER_NO" id="P_LETTER_NO" placeholder=""
                                value="{{ old('P_LETTER_NO') }}">
                        </div>
                    </div>

                    {{-- Food Deduct --}}
                    <div class="mb-3 row container"id="P_FOOD_DEDUCT_div">
                        <label for="P_FOOD_DEDUCT" class="col-sm-3 col-form-label ">Food Deduct : </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="P_FOOD_DEDUCT" id="P_FOOD_DEDUCT" placeholder=""
                                value="{{ old('P_FOOD_DEDUCT') }}">
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-info" id="report">Run Report
                                                Salary</button>
                                        </div>
                        
                        </div>
                </div>

            </form>

        </div>
    </div>

</body>

<script src="/dtjs/popper.min.js" crossorigin="anonymous"></script>
<script src="/dtjs/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="/mainjs/jquery.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }} "></script>
<script type="text/javascript" src="{{ URL::asset('dist/js/adminlte.min.js') }} "></script>
<script src="/mainjs/jquery-ui.js"></script>
<script src="/mainjs/jquery.timepicker.min.js"></script>
<script src="/mainjs/moment.min.js" crossorigin="anonymous"></script>
<script src="/mainjs/jquery.dataTables.min.js"></script>
<script src="/mainjs/moment-duration-format.js"></script>
<link type="text/css" rel="Stylesheet" href="/mainjs/jquery-ui.css" />
<script src="/mainjs/moment.min.js" crossorigin="anonymous"></script>
<script src="/mainjs/moment-duration-format.js"></script>
<script src="/mainjs/select2.min.js"></script>
<link href="/erpcss/select2.min.css" rel="stylesheet" />
<script src="/mainjs/sweetalert2.all.min.js"></script>
<link href="/erpcss/sweetalert2.min.css" rel="stylesheet">


<script>
$(document).ready(function() {
    $('#company_idd').select2();
    $('#report_list').select2();
    $('#P_PAYMENT_DATE').datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true
    });
    $('#P_PRINT_DATE').datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true
    });
    $('#P_DATE').datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true
    });
    $('#P_TO_DATE').datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true
    });
    $('#P_FROM_DATE').datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true
    });
    $('#P_AS_ON').datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true
    });
    $('#P_ATT_DATE').datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true
    });
});
</script>
<script>
  $(document).ready(function() {
    $("#P_FLOOR_ID_div").hide();
$("#P_INCREMENT_TYPE_div").hide();
$("#P_PAYMENT_DATE_div").hide();
$("#P_PRINT_DATE_div").hide();
$("#P_DATE_div").hide();
$("#P_BNOUS_div").hide();
$("#P_STATUS_div").hide();
$("#P_DAYES_div").hide();
$("#P_MONTH_div").hide();
$("#P_FROM_DATE_div").hide();
$("#P_TO_DATE_div").hide();
$("#P_AS_ON_div").hide();
$("#P_ATT_DATE_div").hide();
$("#P_EMP_NO_div").hide();
$("#P_SECTION_NO_div").hide();
$("#P_DEPT_NO_div").hide();
$("#P_COMPANY_div").hide();
$("#P_DES_NO_div").hide();
$("#P_EMP_TYPE_div").hide();
$("#P_WRK_ENT_div").hide();
$("#P_YEAR_div").hide();
$("#P_GRADE_div").hide();
$("#P_RELIGION_div").hide();
$("#P_BLOOD_GROUP_div").hide();
$("#P_SEX_div").hide();
$("#P_SHIFT_CODE_div").hide();
$("#P_BANK_SAL_div").hide();
$("#P_LINE_div").hide();
$("#P_BANK_NAME_div").hide();
$("#P_BILL_div").hide();
$("#P_LATE_DEDUCT_div").hide();
$("#P_LETTER_NO_div").hide();
$("#P_FOOD_DEDUCT_div").hide();




  });
$('#report_list').on('change',function(e){
    e.preventDefault();
   var report_id=$('#report_list').val();
   $("#P_FLOOR_ID_div").hide();
$("#P_INCREMENT_TYPE_div").hide();
$("#P_PAYMENT_DATE_div").hide();
$("#P_PRINT_DATE_div").hide();
$("#P_DATE_div").hide();
$("#P_BNOUS_div").hide();
$("#P_STATUS_div").hide();
$("#P_DAYES_div").hide();
$("#P_MONTH_div").hide();
$("#P_FROM_DATE_div").hide();
$("#P_TO_DATE_div").hide();
$("#P_AS_ON_div").hide();
$("#P_ATT_DATE_div").hide();
$("#P_EMP_NO_div").hide();
$("#P_SECTION_NO_div").hide();
$("#P_DEPT_NO_div").hide();
$("#P_COMPANY_div").hide();
$("#P_DES_NO_div").hide();
$("#P_EMP_TYPE_div").hide();
$("#P_WRK_ENT_div").hide();
$("#P_YEAR_div").hide();
$("#P_GRADE_div").hide();
$("#P_RELIGION_div").hide();
$("#P_BLOOD_GROUP_div").hide();
$("#P_SEX_div").hide();
$("#P_SHIFT_CODE_div").hide();
$("#P_BANK_SAL_div").hide();
$("#P_LINE_div").hide();
$("#P_BANK_NAME_div").hide();
$("#P_BILL_div").hide();
$("#P_LATE_DEDUCT_div").hide();
$("#P_LETTER_NO_div").hide();
$("#P_FOOD_DEDUCT_div").hide();
$('#P_FLOOR_ID').prop('disabled', true);
$('#P_INCREMENT_TYPE').prop('disabled', true);
$('#P_PAYMENT_DATE').prop('disabled', true);
$('#P_PRINT_DATE').prop('disabled', true);
$('#P_DATE').prop('disabled', true);
$('#P_BNOUS').prop('disabled', true);
$('#P_STATUS').prop('disabled', true);
$('#P_DAYES').prop('disabled', true);
$('#P_MONTH').prop('disabled', true);
$('#P_FROM_DATE').prop('disabled', true);
$('#P_TO_DATE').prop('disabled', true);
$('#P_AS_ON').prop('disabled', true);
$('#P_ATT_DATE').prop('disabled', true);
$('#P_EMP_NO').prop('disabled', true);
$('#P_SECTION_NO').prop('disabled', true);
$('#P_DEPT_NO').prop('disabled', true);
$('#P_COMPANY').prop('disabled', true);
$('#P_DES_NO').prop('disabled', true);
$('#P_EMP_TYPE').prop('disabled', true);
$('#P_WRK_ENT').prop('disabled', true);
$('#P_YEAR').prop('disabled', true);
$('#P_GRADE').prop('disabled', true);
$('#P_RELIGION').prop('disabled', true);
$('#P_BLOOD_GROUP').prop('disabled', true);
$('#P_SEX').prop('disabled', true);
$('#P_SHIFT_CODE').prop('disabled', true);
$('#P_BANK_SAL').prop('disabled', true);
$('#P_LINE').prop('disabled', true);
$('#P_BANK_NAME').prop('disabled', true);
$('#P_BILL').prop('disabled', true);
$('#P_LATE_DEDUCT').prop('disabled', true);
$('#P_LETTER_NO').prop('disabled', true);
$('#P_FOOD_DEDUCT').prop('disabled', true);


   $.ajax({
                    url: '/getReportPera/' + report_id,
                    type: "GET",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                       
                            $.each(data, function(key, getReport) {
                             console.log(getReport);
                             $('#'+getReport.parameter_name).prop('disabled', false);

                             $('#'+getReport.parameter_name+'_div').show();


                            });
                        } else {

        
                        }


                        
   $.ajax({
                    url: '/getReportName/' + report_id,
                    type: "GET",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(response) {
                    console.log(response);
                    $('#repoName').val(response.js_report);
                    }
                });
                    }
                });
})

$('#report').on('submit',function(e){

    e.preventDefault();

var fd= $('#report').serialize();

window.open('pdfReport/'+'?'+fd, '_blank', 'width=1300,height=700');
    return false;


})


</script>
</html>