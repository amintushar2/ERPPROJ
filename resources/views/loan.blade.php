<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Employee Loan Entry</title>

    {{-- font awesome cdn --}}

    {{-- font awesome cdn --}}
    <link rel="stylesheet" href="{{URL::asset('plugins/fontawesome-free/css/all.min.css')}}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css">



    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"
        integrity="sha512-KBeR1NhClUySj9xBB0+KRqYLPkM6VvXiiWaSz/8LCQNdRpUm38SWUrj0ccNDNSkwCD9qPA4KobLliG26yPppJA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- <script src="{{ asset('/js/app.js') }}" defer></script> -->


    <!-- <style type="text/css">
    @font-face {
        font-family: SutonnyMJ;
        src: url('/fonts/SutonnyMJ.ttf');
        src: url('/fonts/SutonnyMJ.eot');
        /* IE9 Compat Modes */
        src: url('/fonts/SutonnyMJ.eot?#iefix') format('embedded-opentype'),
            /* IE6-IE8 */
            /* Pretty Modern Browsers */
            url('/fonts/SutonnyMJ.ttf') format('truetype'),
            /* Safari, Android, iOS */
            url('/fonts/SutonnyMJ.svg#FortFoundry') format('svg');
    }

    #loan_app_name {
        font-family: 'SutonnyMJ' !important;
    }
    </style> -->
</head>

<body>
    @section('title', 'Page Title')
    @include('topbar.sidebar')
    <!-- {{-- <div class=" p-3"> --}} -->
    <div class="container-fluid">
        <div class="content-wrapper">
            <div class="row">
                <form id="insert_form">
                    @csrf
                    <div class="container col-lg-10 text-left">
                        <hr />

                        <div class="row">
                            {{-- company name input --}}
                            <div class="col-md-6">
                                <div class="row p-1">
                                    <label for="company_name" class="col-sm-4 col-form-label">Company Name :</label>
                                    <div class="col-sm-7">
                                        <select class="form-select" name="company_no" id="company_no"
                                            aria-label="Default select example">
                                            <option selected>Select One</option>
                                            @foreach($getCompany as $getCompany)
                                            <option value="{{$getCompany->company_id}}">{{$getCompany->company_name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{-- Loan App No input --}}
                            <div class="col-md-6">
                                <div class="row p-1">
                                    <label for="loan_app_name" class="col-sm-4 col-form-label">Loan App No :</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="loan_app_name" name="loan_app_name"
                                            value="{{ old('loan_app_no') }}" readonly>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            {{-- EMP NO input --}}
                            <div class="col-md-6">
                                <div class="row p-1">
                                    <label for="emp_no" class="col-sm-4 col-form-label">EMP NO :</label>
                                    <div class="col-sm-7">
                                        <input type="text" list="empno_list" class="form-control" id="emp_no"
                                            name="emp_no" value="{{ old('empno') }}">
                                        <datalist id="empno_list">

                                            </select>
                                    </div>
                                </div>
                            </div>

                            {{--Employee Name input --}}
                            <div class="col-md-6">
                                <div class="row p-1">
                                    <label for="emp_name" class="col-sm-4 col-form-label">Employee Name :</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="emp_name" name="emp_name"
                                            value="{{ old('emp_name') }}" readonly>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            {{-- Department name input --}}
                            <div class="col-md-6">
                                <div class="row p-1">
                                    <label for="dept_no" class="col-sm-4 col-form-label">Department :</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="dept_no" id="dept_no"
                                            value="{{ old('dept_no') }}" readonly>


                                    </div>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="dept_name" id="dept_name"
                                            value="{{ old('dept_name') }}" readonly>

                                    </div>





                                </div>
                            </div>


                            {{-- Designation input --}}
                            <div class="col-md-6">
                                <div class="row p-1">
                                    <label for="designation" class="col-sm-4 col-form-label">Designation :</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="designation" id="designation"
                                            value="{{ old('designation') }}" readonly>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Joining Date input --}}
                            <div class="col-md-6">
                                <div class="row p-1">
                                    <label for="joining_date" class="col-sm-4 col-form-label">Joining Date :</label>
                                    <div class="col-sm-7">




                                        <input type="text" class="form-control" name="joining_date" id="joining_date"
                                            value="{{ old('joining_date') }}" readonly>
                                    </div>
                                </div>
                            </div>



                            {{-- Section input --}}
                            <div class="col-md-6">
                                <div class="row p-1">
                                    <label for="section_no" class="col-sm-4 col-form-label">Section :</label>
                                    <div class="col-sm-2">

                                        <input type="text" class="form-control" name="section_no" id="section_no"
                                            value="{{ old('section_no') }}" readonly>
                                    </div>
                                    <div class="col-sm-5">

                                        <input type="text" class="form-control" name="section_name" id="section_name"
                                            value="{{ old('section_name') }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Gross Amount input --}}
                            <div class="col-md-6">
                                <div class="row p-1">
                                    <label for="gross_amount" class="col-sm-4 col-form-label">Gross Amount :</label>
                                    <div class="col-sm-7">
                                        <input type="number" class="form-control" name="gross_amount" id="gross_amount"
                                            value="{{ old('gross_amount') }}">
                                    </div>
                                </div>
                            </div>

                            {{-- Loan Approved Date input --}}
                            <div class="col-md-6">
                                <div class="row p-1">
                                    <label for="loan_approved_date" class="col-sm-4 col-form-label">Loan Approved Date
                                        :</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="loan_approved_date"
                                            id="loan_approved_date" value="{{ old('loan_approved_date') }}"
                                            placeholder="YYYY-MM-DD">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            {{-- Application Date input --}}
                            <div class="col-md-6">
                                <div class="row p-1">
                                    <label for="application_date" class="col-sm-4 col-form-label">Application Date
                                        :</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="application_date"
                                            id="application_date" value="{{ old('application_date') }}"
                                            placeholder="YYYY-MM-DD">
                                    </div>
                                </div>
                            </div>

                            {{-- Sanction Amount input --}}
                            <div class="col-md-6">
                                <div class="row p-1">



                                    <label for="new_instt_date" class="col-sm-4 col-form-label">New Install Date
                                        :</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="new_instt_date"
                                            id="new_instt_date" value="{{ old('new_instt_date') }}"
                                            placeholder="YYYY-MM-DD">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            {{-- First Install Date input --}}
                            <div class="col-md-6">
                                <div class="row p-1">
                                    <label for="first_install_date" class="col-sm-4 col-form-label">First Install Date
                                        :</label>
                                    <div class="col-sm-7">

                                        <input type="text" class="form-control" name="first_install_date"
                                            id="first_install_date" value="{{ old('first_install_date') }}"
                                            placeholder="YYYY-MM-DD">




                                        <!-- <input type="date" class="form-control" name="first_install_date"
                                    id="first_install_date" value="{{ old('first_install_date') }}"> -->
                                    </div>
                                </div>
                            </div>

                            {{-- Department name input --}}
                            <div class="col-md-6">
                                <div class="row p-1">
                                    <label for="sanction_amount" class="col-sm-4 col-form-label">Sanction Amount
                                        :</label>
                                    <div class="col-sm-7">
                                        <input type="number" class="form-control" name="sanction_amount"
                                            id="sanction_amount" value="{{ old('sanction_amount') }}">
                                    </div>


                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Installment Size selection --}}
                            <div class="col-md-6">
                                <div class="row p-1">
                                    <label for="installment_size" class="col-sm-4 col-form-label">Installment Size
                                        :</label>
                                    <div class="col-sm-7">
                                        <input type="number" class="form-control" name="installment_size"
                                            id="installment_size" value="{{ old('installment_size') }}">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            {{-- Period input --}}
                            <div class="col-md-6">
                                <div class="row p-1">
                                    <label for="period" class="col-sm-4 col-form-label">Period :</label>
                                    <div class="col-sm-7">
                                        <input type="number" class="form-control" name="period" id="period"
                                            value="{{ old('period') }}">
                                    </div>
                                </div>
                            </div>

                            {{-- New Period input --}}
                            <div class="col-md-6">
                                <div class="row p-1">
                                    <label for="new_period" class="col-sm-4 col-form-label">New Period :</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="new_period" id="new_period"
                                            value="{{ old('new_period') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Pre Loan Amount input --}}
                            <div class="col-md-6">
                                <div class="row p-1">
                                    <label for="pre_loan_amount" class="col-sm-4 col-form-label">Pre Loan Amount
                                        :</label>
                                    <div class="col-sm-7">
                                        <input type="number" class="form-control" name="pre_loan_amount"
                                            id="pre_loan_amount" value="{{ old('pre_loan_amount') }}">
                                    </div>
                                </div>
                            </div>

                            {{-- Pre Balance Amount input --}}
                            <div class="col-md-6">
                                <div class="row p-1">
                                    <label for="pre_balance_amount" class="col-sm-4 col-form-label">Pre Balance Amount
                                        :</label>
                                    <div class="col-sm-7">
                                        <input type="number" class="form-control" name="pre_balance_amount"
                                            id="pre_balance_amount" value="{{ old('pre_balance_amount') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            {{-- company name input --}}
                            <div class="col-md-6">
                                <div class="row p-1">
                                    <label for="ref_name" class="col-sm-4 col-form-label">Reference Name :</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="ref_name" id="ref_name"
                                            value="{{ old('ref_name') }}">
                                    </div>
                                </div>
                            </div>

                            {{-- Department name input --}}
                            <div class="col-md-6">
                                <div class="row p-1">
                                    <label for="ref_des_name" class="col-sm-4 col-form-label">Ref Des Name :</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="ref_des_name" id="ref_des_name"
                                            value="{{ old('ref_des_name') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr />
                    </div>




                    <div class="row-md-6 m-3 text-center">
                        <button class="btn btn-success" type="submit" id="insert_btn">Save</button>
                        <button class="btn btn-danger" type="button">Cancel</button>
                    </div>

                    <div class="container justify-content-center" style="margin-top : 20px">
                        @if( Session::get('delet'))
                        <div class="alert alert-success">
                            {{Session::get('delet')}}
                        </div>
                        @endif
                        @if(Session::get('deletef'))
                        <div class="alert alert-danger">
                            {{Session::get('deletef')}}
                        </div>
                        @endif

                    </div>



            </div>
            </form>

            <div class="container-fluid">
                <form action="" name="add_item" id="add_item" class="form-inline">
                    <table class="table table-striped table-sm table-center align-middle" id="maintb">
                        <thead>
                            <tr>
                                <th>Install No</th>
                                <th>PBBOM</th>
                                <th>Install Amount</th>
                                <th>Install Date</th>
                                <th>PBEOM</th>
                                <th>Pay Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>

                </form>

            </div>
        </div>
    </div>
</body>



<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
    integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }} "></script>
<script type="text/javascript" src="{{ URL::asset('dist/js/adminlte.min.js') }} "></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script src="https://unpkg.com/moment-duration-format@2.3.2/lib/moment-duration-format.js"></script>

<link type="text/css" rel="Stylesheet"
    href="http://ajax.microsoft.com/ajax/jquery.ui/1.8.6/themes/smoothness/jquery-ui.css" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js
"></script>
<link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css
" rel="stylesheet">









<script>
$(function() {
    $("#joining_date").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true

    });

    $("#first_install_date").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true

    });
    $("#application_date").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true

    });
    $("#loan_approved_date").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true

    });


});
</script>
<script>
$(function() {

    $("#period").on('keyup', function() {

        var sanctionAmount = parseInt($('#sanction_amount').val());
        var period = parseInt($('#period').val());
        var installmentsize = sanctionAmount / period;
        console.log(installmentsize);
        console.log(period);
        console.log(sanctionAmount);

        $('#installment_size').val(installmentsize);

    });
    //insert form data with ajax request


   function storer2() {



        var loanAppNo = $('#loan_app_name').val();


        var totalamount = (parseInt($('#sanction_amount').val()));
        var firdtInsDat = $('#first_install_date').val();
        var installmonth = (parseInt($('#period').val()));
        var installAmount = totalamount / installmonth;
        var ball = totalamount - installAmount;
        // console.log(firdtInsDat);
        $('#maintb tr:last').after(
            '<tr><td><input type="text" class="form-control col-sm-6" id="loanAppNo" name="loanAppNo[]" value="' +
            loanAppNo + '" hidden=""><input type="text" class="form-control col-sm-6"data-id="' +
            loanAppNo +
            '" id="install_no" name="install_no[]" value="1"></td><td><input type="text" class="form-control col-sm-6" id="pbbom" name="pbbom[]" value="' +
            totalamount +
            '"></td><td id="installamounttd"> <input type="text" class="form-control col-sm-6" id="installAmount" name="installAmount[]" value="' +
            installAmount +
            '"></td><td > <input type="text" class="form-control col-sm-6" id="firdtInsDate" name="firdtInsDate[]" value="' +
            firdtInsDat + '"></td><td><input type="text" class="form-control col-sm-6" id="pbeom" name="pbeom[]" value="' + ball + '"></td><td>' + 'Deu' + '</td><td>' +
            'Deu' +
            '</td><td>' + 'Deu' + '</td></tr>');
        var erty = parseInt($('table:first tr').find('#pbeom').last().text())

        if (!erty == '0') {
            for (let i = 1; i < installmonth; i++) {

                // some code
                var pbbom = parseInt($('table:first tr').find('#pbeom').last().text());
                var installamounttd = parseInt($('table:first tr').find('#installamounttd').last()
                    .text());
                var installDate = $('table:first tr').find('#firdtInsDate').last().text();
                var newDate = moment(firdtInsDat, "YYYY-MM-DD").add(i, 'months').format('YYYY-MM-DD');

                var pbeom = pbbom - installAmount;
                var ttER = i + 1
                $('#maintb tr:last').after(
                    '<tr ><td> <input type="text" class="form-control col-sm-6" id="loanAppNo" name="loanAppNo[]"  value="' +
                    loanAppNo +
                    '"hidden=""><input type="text" class="form-control col-sm-6" id="install_no" name="install_no[]" value="' +
                    ttER +
                    '"> </td><td name="balance"> <input type="text" class="form-control col-sm-6" id="pbbom" name="pbbom[]" value="' +
                    pbbom +
                    '"></td><td id="installamounttd"> <input type="text" class="form-control col-sm-6" id="installAmount" name="installAmount[]" value="' +
                    installAmount +
                    '"></td><td> <input type="text" class="form-control col-sm-6" id="firdtInsDate" name="firdtInsDate[]" value="' +
                    newDate + '"></td><td><input type="text" class="form-control col-sm-6" id="pbeom" name="pbeom[]" value="'  +
                    pbeom + '"></td><td>' + 'Deu' +
                    '</td><td>' + 'Deu' +
                    '</td><td>' +
                    '<button class="btn btn-success" type="check" id="check">Click</button>' +
                    '</td></tr>');
                $(this).prop("disabled", true);

            }
        }
        console.log(pbbom);
        console.log('ddd' + newDate + 'EE' + firdtInsDat);

    }








});
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

<script>
$('#company_no').on('change', function(e) {

    e.preventDefault();

    $.ajaxSetup({

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var comId = $('#company_no').val();



    $.ajax({
        type: 'GET',
        url: 'getemp/' + comId,
        contentType: false,
        processData: false,
        dataType: 'json',
        data: {
            "_token": "{{ csrf_token() }}"
        },
        success: function(response) {
            var res = response.data;
            var html = '';
            var htmldata = res.map(function(item) {

                html += '<option value=' + item.empno + '>';

                console.log(item);
            })
            //console.log(htmldata)
            $("#empno_list").empty();
            $("#empno_list").append(html);

        },
        error: function(response) {

        }
    });
});


$(document).on('keyup', '#emp_no', function(e) {

    e.preventDefault();

    $.ajaxSetup({

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var empno = $('#emp_no').val();
    var comId = $('#company_no').val();

    var data = {
        empno: empno,
        comId: comId
    };

    console.log(data);
    $.ajax({
        type: 'GET',
        url: '/getempdet',

        data: data,

        success: function(data) {
            console.log(data);
            $.each(data, function(key, deptList) {

                {
                    if (data) {

                        $.each(data, function(key, getEmpList) {
                            console.log(getEmpList);
                            $('#joining_date').val(getEmpList.joining_date);
                            $('#emp_name').val(getEmpList.emp_name);
                            $('#designation').val(getEmpList.des_name);
                            $('#dept_name').val(getEmpList.dept_name);
                            $('#dept_no').val(getEmpList.dept_no);
                            $('#section_name').val(getEmpList.section_name);
                            $('#section_no').val(getEmpList.section_no);
                            $('#gross_amount').val(getEmpList.gross);


                        });
                    } else {}
                }


            });
        }
    });
});

$("#insert_form").submit(function(e) {
    e.preventDefault();

    $.ajaxSetup({

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    const fd = new FormData(this);
    console.log(fd);
    $.ajax({
        type: 'POST',
        url: 'loansave',
        data: fd,
        contentType: false,
        processData: false,
        dataType: 'json',
        complete: function(response) {
            console.log(response);
            if (response.status == 200) {
                console.log(response.responseJSON.loan_nooo);

                var loanId = response.responseJSON.loan_nooo;
                var date = response.responseJSON.jDate;
                $('#loan_app_name').val(loanId);

                storer();
                loandata();
            }
        },
        error: function(response) {
            alert('dd');
            console.log(response);

        }
    });
});



function loandata(){

    $.ajaxSetup({

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var arrData = $('#add_item').serializeArray();

    console.log(typeof(arrData));
    console.log(arrData);

    console.log($(this).serializeArray());

    $.ajax({

        url: 'loandtsave',
        method: "GET",
        data: $('#add_item').serialize(),
        type: 'json',
        success: function(response) {
            console.log(response);
            if (response.status == 200) {

Swal.fire(
    'Added!',
    'Loan Added Successfully!',
    'success'
)
}

        },
        error: function(response) {
            console.log(response);

        }
    });
};




function storer() {



        var loanAppNo = $('#loan_app_name').val();


        var totalamount = (parseInt($('#sanction_amount').val()));
        var firdtInsDat = $('#first_install_date').val();
        var installmonth = (parseInt($('#period').val()));
        var installAmount = totalamount / installmonth;
        var ball = totalamount - installAmount;
        // console.log(firdtInsDat);
        $('#maintb tr:last').after(
            '<tr><td><input type="text" class="form-control col-sm-6" id="loanAppNo" name="loanAppNo[]" value="' +
            loanAppNo + '" hidden=""><input type="text" class="form-control col-sm-6"data-id="' +
            loanAppNo +
            '" id="install_no" name="install_no[]" value="1"></td><td><input type="text" class="form-control col-sm-6" id="pbbom" name="pbbom[]" value="' +
            totalamount +
            '"></td><td id="installamounttd"> <input type="text" class="form-control col-sm-6" id="installAmount" name="installAmount[]" value="' +
            installAmount +
            '"></td><td > <input type="text" class="form-control col-sm-6" id="firdtInsDate" name="firdtInsDate[]" value="' +
            firdtInsDat + '"></td><td  id="pbeom"><input type="text" class="form-control col-sm-6 inputField" id="pbeomr" name="pbeomr[]" value="' + ball + '"></td><td>' + ' '
             + '</td><td><input type="text" class="form-control col-sm-6 inputField" id="status" name="status[]" value="' +
            'Deu' +
            '"></td></tr>');
        var erty = parseInt($('table#maintb tr:last input[id=pbeomr]').val());

        
        ///parseInt($('td:last input#pbeomr').val());
        console.log(erty);
        

        if (!erty == '0') {
            for (let i = 1; i < installmonth; i++) {

                // some code
                var pbbom = parseInt($('table#maintb tr:last input[id=pbeomr]').val());
                var installamounttd = parseInt($('table:first tr').find('#installamounttd').last()
                    .text());
                var installDate = $('table:first tr').find('#firdtInsDate').last().text();
                var newDate = moment(firdtInsDat, "YYYY-MM-DD").add(i, 'months').format('YYYY-MM-DD');

                var pbeom = pbbom - installAmount;
                var ttER = i + 1
                $('#maintb tr:last').after(
                    '<tr ><td> <input type="text" class="form-control col-sm-6" id="loanAppNo" name="loanAppNo[]"  value="' +
                    loanAppNo +
                    '"hidden=""><input type="text" class="form-control col-sm-6" id="install_no" name="install_no[]" value="' +
                    ttER +
                    '"> </td><td name="balance"> <input type="text" class="form-control col-sm-6" id="pbbom" name="pbbom[]" value="' +
                    pbbom +
                    '"></td><td id="installamounttd"> <input type="text" class="form-control col-sm-6" id="installAmount" name="installAmount[]" value="' +
                    installAmount +
                    '"></td><td> <input type="text" class="form-control col-sm-6" id="firdtInsDate" name="firdtInsDate[]" value="' +
                    newDate + '"></td><td id="pbeom" name="pbeom"><input type="text" class="form-control col-sm-6 inputField" id="pbeomr" name="pbeomr[]" value="' +
                    pbeom + '"></td><td>' + ' ' +
                    '</td><td><input type="text" class="form-control col-sm-6 inputField" id="status" name="status[]" value="' + 'Deu' +
                    '"></td></tr>');
                $(this).prop("disabled", true);

            }
        }
        console.log(pbbom);
        console.log('ddd' + newDate + 'EE' + firdtInsDat);

    }
</script>



</html>