<!doctype html>
<html lang="en">

<head>
    <title>Employee Information</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- {{-- font awesome cdn --}} -->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- {{-- font awesome cdn --}} -->
    <link rel="stylesheet" href="{{URL::asset('plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="erpcss/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap CSS -->
    <link href="erpcss/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="mainjs/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="erpcss/bootstrap.min.css">
    <link rel="stylesheet" href="erpcss/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="erpcss/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="bootstrap_icon/bootstrap-icons.min.css">
    <script src="mainjs/adminlte.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <style type="text/css">

    </style>
    <style type="text/css">
    @media only screen and (max-width: 600px) {
        html {
            font-size: .7rem; // you can also use px here...
        }
    }


    /* Large devices (laptops/desktops, 992px and up) -- This would display the text at 10.0rem on laptops and larger screens */

    @media only screen and (min-width: 992px) {
        html {
            font-size: .5rem; // you can also use px here...
        }
    }


    @media only screen and (min-width: 1366px) {
        html {
            font-size: .8rem; // you can also use px here...
        }

        .select2-container .select2-selection--single {
            height: 34px !important;
        }

    }

    @media only screen and (min-width: 1440px) {
        html {
            font-size: 1rem; // you can also use px here...
        }

        .select2-selection__rendered {}

        .select2-container .select2-selection--single {
            height: 37px !important;
        }

        .select2-selection__arrow {}

        .select2.select2-container {}

    }

    .text-style:hover {
        text-decoration: underline;
    }

    label {
        font-size: 10px;
    }

    #ui-datepicker-div {
        display: none;
    }

    @media only screen and (max-width: 400px) {
        body {
            font-size: 50px;
        }
    }
    </style>


    <style type="text/css">
    @font-face {
        font-family: SutonnyMJ;
        src: url('/fonts/SutonnyMJ.ttf');
        src: url('/fonts/SutonnyMJ.eot');
        src: url('/fonts/SutonnyMJ.eot?#iefix') format('embedded-opentype'),
            url('/fonts/SutonnyMJ.ttf') format('truetype'),
            url('/fonts/SutonnyMJ.svg#FortFoundry') format('svg');
    }

    #b_name,
    #depent_name_bangla,
    #relation_bn,
    #address_bn,
    #dep_name_bn,
    #relation_bn,
    #address_bn {
        font-family: 'SutonnyMJ' !important;
    }

    .select2.select2-container {
        width: 100% !important;
    }
    </style>


</head>

<body>
    @section('title', 'Page Title')
    @include('topbar.sidebar')
    <div class="container-fluid">








        <div class="content-wrapper">





            <main>
                <nav>
                    <div class="nav nav-tabs position-fix top-0 start-0 " id="nav-tab" role="tablist"
                        style="background-color:rgb(52, 58, 64)">
                        <button class="nav-link active link-light" id="per-tab" data-bs-toggle="pill"
                            data-bs-target="#per" type="button" role="tab" aria-controls="per"
                            aria-selected="true">Personal Info</button>

                        <button class="nav-link link-light" id="off-tab" data-bs-toggle="pill" data-bs-target="#off"
                            type="button" role="tab" aria-controls="off" aria-selected="false">Official Info</button>
                        <button class="nav-link link-light" id="add-tab" data-bs-toggle="pill" data-bs-target="#add"
                            type="button" role="tab" aria-controls="add" aria-selected="false">Location</button>
                        <button class="nav-link link-light" id="academi-tab" data-bs-toggle="pill"
                            data-bs-target="#academi" type="button" role="tab" aria-controls="academi"
                            aria-selected="false">Education</button>

                        <button class="nav-link link-light" id="course-tab" data-bs-toggle="pill"
                            data-bs-target="#course" type="button" role="tab" aria-controls="course"
                            aria-selected="false">Short Course</button>
                        <button class="nav-link link-light" id="train-tab" data-bs-toggle="pill" data-bs-target="#train"
                            type="button" role="tab" aria-controls="train" aria-selected="false">Training</button>
                        <button class="nav-link link-light" id="exp-tab" data-bs-toggle="pill" data-bs-target="#exp"
                            type="button" role="tab" aria-controls="exp" aria-selected="false">Experience</button>
                        <button class="nav-link link-light" id="nomi-tab" data-bs-toggle="pill" data-bs-target="#nomi"
                            type="button" role="tab" aria-controls="nomi" aria-selected="false">Nominee</button>

                        <!-- <button class="nav-link link-light" id="leave-tab" data-bs-toggle="pill" data-bs-target="#leave"
                            type="button" role="tab" aria-controls="leave" aria-selected="false">Earn Leave</button> -->
                        <button class="nav-link link-light" id="job-tab" data-bs-toggle="pill" data-bs-target="#job"
                            type="button" role="tab" aria-controls="job" aria-selected="false">JOB HISTORY</button>


                    </div>
                </nav>







                <div class="tab-content p-15 overflow-auto" id="nav-tabContent" style="width:inline-block">

                    @include('hrm.empentry.emppersonal')
                    @include('hrm.empentry.empofficial')
                    @include('hrm.empentry.empadress')
                    @include('hrm.empentry.empacademic')
                    @include('hrm.empentry.empexperience')
                    @include('hrm.empentry.empnomeenee')
                    @include('hrm.empentry.empshortcourse')
                    @include('hrm.empentry.emptrain')
                    @include('hrm.empentry.empjobhistory')
                    @include('hrm.empentry.empimg')


            </main>
        </div>
    </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <script src="dtjs/popper.min.js" crossorigin="anonymous"></script>
    <script src="dtjs/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="mainjs/jquery.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }} "></script>
    <script type="text/javascript" src="{{ URL::asset('dist/js/adminlte.min.js') }} "></script>
    <script src="mainjs/jquery-ui.js"></script>
    <script src="mainjs/jquery.timepicker.min.js"></script>
    <script src="mainjs/moment.min.js" crossorigin="anonymous"></script>
    <script src="mainjs/jquery.dataTables.min.js"></script>
    <script src="mainjs/moment-duration-format.js"></script>
    <link type="text/css" rel="Stylesheet" href="mainjs/jquery-ui.css" />
    <script src="mainjs/moment.min.js" crossorigin="anonymous"></script>
    <script src="mainjs/moment-duration-format.js"></script>
    <script src="mainjs/select2.min.js"></script>
    <link href="erpcss/select2.min.css" rel="stylesheet" />
    <script src="mainjs/sweetalert2.all.min.js"></script>
    <link href="erpcss/sweetalert2.min.css" rel="stylesheet">


    <script type="text/javascript">
    $('input, select').on('keydown', function(e) {
        if (e.keyCode == 13) { // Check if the pressed key is Enter (keyCode 13)
            e.preventDefault(); // Prevent the default Enter key action
        }
    });




    //empFind
    $('#findemp').on('click', function(e) {
        e.preventDefault();
        var empno = $("#empno").val();
        $('#emppersonalSave').hide();
        $('#offc_save').hide();

        $('#emppersonalUpdate').show();
        $('#offc_update').show();
        $('#updateorsave').val('update');
//alert($('#updateorsave').val());
        $.ajax({
            url: 'empDetailsSearch',
            method: 'get',
            data: {
                'empno': empno
            },
            success: function(data) {

                $.each(data, function(key, empdt) {
                    //   alert(empdt.age2);

                    //emp_personal
                    $('#first_name').val(empdt.first_name);
                    $('#middle_name').val(empdt.middle_name);
                    $('#last_name').val(empdt.last_name);
                    $('#card_no').val(empdt.card_no);
                    $('#comapnylist').val(empdt.company_id).change();
                    $('#father_name').val(empdt.father_name);
                    $('#mother_name').val(empdt.mother_name);
                    $('#husband_name').val(empdt.husband_name);
                    $('#dob').val(moment(empdt.dob).format("YYYY-MM-DD"));
                    $('#as_on_date').val(moment(empdt.as_on).format("YYYY-MM-DD"));



                    $('#as_on').val('empdt.as_on');
                    $('#age').val(empdt.age);
                    $('#b_name').val(empdt.b_name);
                    $('#religion_id').val(empdt.religion_id);
                    $('#nationality_desc').val(empdt.nationality_desc);
                    $('#status').val(empdt.status);
                    $('#sex').val(empdt.sex);
                    $('#national_id_no').val(empdt.national_id_no);
                    if (empdt.id_card_issue == null) {
                        $('#id_card_issue').val(null);
                    } else {
                        $('#id_card_issue').val(moment(empdt.id_card_issue).format(
                            "YYYY-MM-DD"));
                    }
                    $('#passport_no').val(empdt.passport_no);
                    $('#last_education').val(empdt.last_education);


                    if (empdt.valid_till == null) {
                        $('#valid_till').val(null);
                    } else {
                        $('#valid_till').val(moment(empdt.valid_till).format("YYYY-MM-DD"));
                    }
                    $('#place_of_issue').val(empdt.place_of_issue);
                    $('#id_mark').val(empdt.id_mark);
                    $('#birthday_id').val(empdt.birthday_id);
                    $('#blood_group').val(empdt.blood_group);
                    $('#hbs_test').val(empdt.hbs_test);
                    $('#emp_mobile_no').val(empdt.emp_mobile_no);
                    $('#sms_mobile_no').val(empdt.sms_mobile_no);
                    $('#office_food').val(empdt.office_food);
                    $('#marial_status').val(empdt.marial_status).change();
                    $('#ageDet').val(empdt.age2);


                    var emp_pic_link = "http://192.168.189.205:81/emp_photo/" + empdt
                        .empno + ".jpg";
                    $("#preview-image").attr("src", emp_pic_link);

                    var emp_sign_link = "http://192.168.189.205:81/emp_sign/" + empdt
                        .empno + ".jpg";
                    $("#preview-sign").attr("src", emp_sign_link);
                    //emp_official
                    $.each(empdt.getempofficial, function(key, getempofficial) {
                        //alert(getempofficial.increment_date);
                        $('#comapnylist_of').val(getempofficial.company_id)
                            .change();
                        $('#deptList').val(getempofficial.dept_no).change();
                        $('#section_no').val(getempofficial.section_no).change();
                        // $('#floorList').val(getempofficial.floor_id).change();
                        $('#line').val(getempofficial.line).change();
                        $('#des_id').val(getempofficial.des_id).change();
                        $('#emp_type').val(getempofficial.emp_type).change();
                        $('#grade_id').val(getempofficial.grade_id);
                        $('#shift_code').val(getempofficial.shift_code).change();
                        $('#cal_code').val(getempofficial.cal_code);
                        $('#weekly_off').val(getempofficial.weekly_off);
                        $('#opt_no').val(getempofficial.opt_no);
                        $('#joining_date').val(moment(getempofficial.joining_date)
                            .format("YYYY-MM-DD"));
                        $('#as_on_join').val(getempofficial.as_on_join);


                        if (getempofficial.conform_date == null) {
                            $('#conform_date').val(null);
                        } else {
                            $('#conform_date').val((moment(getempofficial
                                .conform_date).format("YYYY-MM-DD")));
                        }


                        if (getempofficial.increment_date == null) {
                            $('#increment_date').val('');
                        } else {
                            $('#increment_date').val(moment(getempofficial
                                .increment_date).format("YYYY-MM-DD"));
                        }

                        //$('#increment_date').val(moment(getempofficial.increment_date).format("YYYY-MM-DD"));
                        $('#provision_period').val(getempofficial.provision_period);
                        $('#lv_cat_id').val(getempofficial.lv_cat_id);
                        $('#allw_cat_id').val(getempofficial.allw_cat_id);
                        $('#s_group_name').val(getempofficial.s_group_name);
                        $('#work_ent').val(getempofficial.work_ent);
                        $('#ot_ent').val(getempofficial.ot_ent);
                        $('#res_ent').val(getempofficial.res_ent);
                        $('#tran_ent').val(getempofficial.tran_ent);
                        $('#pf_ent').val(getempofficial.pf_ent);
                        $('#tax_ent').val(getempofficial.tax_ent);
                        $('#pro_fund').val(getempofficial.pro_fund);
                        // $('#increment_date').val(moment(getempofficial
                        //     .increment_date).format("YYYY-MM-DD"));
                        $('#gross').val(getempofficial.gross);
                        $('#other_allowance').val(getempofficial.other_allowance);
                        $('#bank_ac_no').val(getempofficial.bank_ac_no);
                        $('#tin_no').val(getempofficial.tin_no);
                        $('#tax_deduction').val(getempofficial.tax_deduction);
                        $('#termination_date').val(getempofficial.termination_date);
                        $('#resigned_date').val(getempofficial.resigned_date);
                        $('#reason').val(getempofficial.reason);
                        $('#service_book_number').val(getempofficial
                            .service_book_number);
                        $('#ac_no').val(getempofficial.ac_no);

                        if ($('#floorList').val() == null) {
                            $('#floorList').val(getempofficial.floor_id).change();
                        } else {
                            alert('s');
                        }

                    });

                    //emp_location
                    $.each(empdt.getemploc, function(key, getemploc) {
                        console.log(getemploc);

                        $('#p_address').val(getemploc.p_address);
                        $('#p_village').val(getemploc.p_village);
                        $('#p_post_office').val(getemploc.p_post_off);
                        $('#p_police_station').val(getemploc.p_police_station);
                        $('#p_city').val(getemploc.p_city);
                        $('#p_district').val(getemploc.p_district);
                        $('#p_phone').val(getemploc.p_phone);
                        $('#p_fax').val(getemploc.p_fax);
                        $('#p_pin_code').val(getemploc.p_pin_code);
                        $('#p_cperson').val(getemploc.p_cperson);
                        $('#r_address').val(getemploc.r_address);
                        $('#r_city').val(getemploc.r_city);
                        $('#r_district').val(getemploc.r_district);
                        $('#r_phone').val(getemploc.r_phone);
                        $('#r_fax').val(getemploc.r_fax);
                        $('#r_mobile').val(getemploc.r_mobile);
                        $('#r_email').val(getemploc.r_email);
                        $('#r_cperson').val(getemploc.r_cperson);


                    });

                    //emp_education
                    $.each(empdt.getempedu, function(key, getempedu) {
                        console.log(getemploc);

                        $('#empnoedu').val(getempedu.empno);
                        $('#name_of_ins').val(getempedu.name_of_ins);
                        $('#passed_exam').val(getempedu.passed_exam);
                        $('#division').val(getempedu.division);
                        $('#year').val(getempedu.year);
                        $('#marks').val(getempedu.marks);
                        $('#board').val(getempedu.board);
                        $('#subject').val(getempedu.subject);


                    });

                    //emp_nominee
                    $.each(empdt.getemploc, function(key, getemploc) {
                        console.log(getemploc);

                        $('#empnoNominee').val(getemploc.empno);
                        $('#depd_name').val(getemploc.depd_name);
                        $('#depent_name_bangla').val(getemploc.depent_name_bangla);
                        $('#relationship').val(getemploc.relationship);
                        $('#relation_bn').val(getemploc.relation_bn);
                        $('#address').val(getemploc.address);
                        $('#d_age').val(getemploc.d_age);
                        $('#d_sex').val(getemploc.d_sex);
                        $('#percentage').val(getemploc.percentage);


                    });

                });
            },
            error: function(response) {

            }
        });


    });

    $("#empno").on('keyup', function(e) {
        e.preventDefault();
        var empno = $("#empno").val();
        $('#empof_id').val(empno);
        $('#card_no').val(empno);
        $('#empadempno').val(empno);
        $('#empnoedu').val(empno);
        $('#empnoshtcourse').val(empno);
        $('#empnoNominee').val(empno);
        $('#empnojob').val(empno);
        $('#empnotraining').val(empno);
        $('#empnoexp').val(empno);



        // alert(empno);
        $.ajax({
            url: 'empsearch',
            method: 'get',
            data: {
                'search_key': empno
            },
            success: function(response) {
                var res = response.data;
                var html = '';
                var htmldata = res.map(function(item) {

                    html += '<option value=' + item.new_empno + '>';

                    //console.log(item);
                })
                //console.log(htmldata)
                $("#empno_list").empty();
                $("#empno_list").append(html);

            },
            error: function(response) {

            }
        });
    });






    $(function() {


        
        $("#emppersonalSave2").submit(function(e) {
            e.preventDefault();
           // alert($('#updateorsave').val());
       var up=    $('#updateorsave').val()
            $.ajaxSetup({

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const fd = new FormData(this);

            console.log(fd);
            var empno = $("#empno").val();



            $.ajax({

                url: 'empSearchExist',
                method: 'get',
                data: {
                    'empno': empno,
                },

                success: function(data) {
                    console.log(data);

                    $.each(data, function(key, getEmpExist) {
                        console.log(getEmpExist);
                        if (getEmpExist.empcount > 0 && up =='new') {
                            Swal.fire(
                                'Error!',
                                'Employee No Already Exsist!',
                                'Error'
                            )
                        } else {

                            $.ajax({

                                url: 'emppersonalsave',
                                method: 'POST',
                                data: fd,
                                cache: false,
                                contentType: false,
                                processData: false,
                                dataType: 'json',
                                success: function(response) {
                                    console.log(response);
                                    if (response.status == 200) {

                                        Swal.fire(
                                            'Added!',
                                            'Employee Added Successfully!',
                                            'success'
                                        )
                                    } else {
                                        Swal.fire(
                                            'Error!',
                                            'Update Error!',
                                            'Error'
                                        )

                                    }
                                },
                                error: function(response) {

                                    console.log(response);

                                    $('#massege').html(response
                                        .responseJSON.errors.empno);
                                    console.log(response.responseJSON
                                        .errors);

                                }
                            });




                        }

                    })





                },
                error: function(response) {

                    console.log(response);

                    $('#massege').html(response.responseJSON.errors.empno);
                    console.log(response.responseJSON.errors);

                }
            });












































        });


        //EmpPersonal Update

        $("#empofficialSave").submit(function(e) {
            e.preventDefault();
            var id = $('#empof_id').val();
            //  alert(id);
            $.ajaxSetup({

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const fd = new FormData(this);

            console.log(fd);

            $.ajax({

                url: 'empoffcsave',
                method: 'POST',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status == 200) {

                        Swal.fire(
                            'Added!',
                            'Employee Added Successfully!',
                            'success'
                        )
                    } else {
                        Swal.fire(
                            'Error!',
                            'Update Error!',
                            'Error'
                        )

                    }
                },
                error: function(data) {

                    console.log(data);

                }
            });

        });






        $("#empadressSave").submit(function(e) {
            e.preventDefault();
            var id = $('#empadempno').val();
            // alert(id);
            $.ajaxSetup({

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const fd = new FormData(this);

            console.log(fd);

            $.ajax({

                url: 'empaddcsave',
                method: 'POST',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status == 200) {

                        Swal.fire(
                            'Added!',
                            'Employee Added Successfully!',
                            'success'
                        )
                    }
                },
                error: function(data) {

                    console.log(data);

                }
            });

        });


        $("#empEduInsert").submit(function(e) {
            e.preventDefault();
            var id = $('#empnoedu').val();
            //  alert(id);
            $.ajaxSetup({

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const fd = new FormData(this);

            console.log(fd);

            $.ajax({

                url: 'empEducsave',
                method: 'POST',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {

                    if (response.status == 200) {
                        var empno = $('#empnoedu').val();
                        //alert(empno);
                        $.get("{{ URL::to('getEdu') }}" + '/' + empno, function(data)

                            {
                                $('#emp_edu_data').empty().html(data);
                            });
                        Swal.fire(
                            'Added!',
                            'Employee Added Successfully!',
                            'success'
                        )
                    }
                },
                error: function(data) {

                    console.log(data);

                }
            });

        });






        $("#empshort").submit(function(e) {
            e.preventDefault();

            var id = $('#empnoshtcourse').val();
            //  alert(id);
            $.ajaxSetup({

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const fd = new FormData(this);

            console.log(fd);

            $.ajax({

                url: 'empShortSave',
                method: 'POST',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {

                    if (response.status == 200) {
                        var empno = $('#empnoshtcourse').val();

                        $.get("{{ URL::to('getCourse') }}" + '/' + empno, function(data)

                            {
                                $('#emp_course_data').empty().html(data);

                            })
                        Swal.fire(
                            'Added!',
                            'Employee Added Successfully!',
                            'success'
                        )
                    }
                },
                error: function(response) {

                    console.log(response);

                }
            });



        });




        $("#empFamForm").submit(function(e) {
            e.preventDefault();

            var id = $('#empnoNominee').val();
            //alert(id);
            $.ajaxSetup({

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const fd = new FormData(this);

            console.log(fd);

            $.ajax({

                url: 'empNomineeSave',
                method: 'POST',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status == 200) {
                        var empno = $('#empnoNominee').val();
                        //alert(empno);
                        $.get("{{ URL::to('getNome') }}" + '/' + empno, function(data)

                            {
                                $('#emp_nom_data').empty().html(data);

                            })
                        Swal.fire(
                            'Added!',
                            'Employee Added Successfully!',
                            'success'
                        )
                    } else {
                        Swal.fire(
                            'Error!',
                            'Nomeeni Already Added!',
                            'error'
                        )
                    }
                },
                error: function(response) {

                    console.log(response);

                }
            });



        });

        $("#empJob").submit(function(e) {
            e.preventDefault();

            var id = $('#empnojob').val();
            //    alert(id);
            $.ajaxSetup({

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const fd = new FormData(this);

            console.log(fd);

            $.ajax({

                url: 'empHistory',
                method: 'POST',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {

                    if (response.status == 200) {
                        var empno = $('#empnojob').val();
                        //alert(empno);
                        var empno = $('#empnojob').val();

                        $.get("{{ URL::to('getJob') }}" + '/' + empno, function(data) {
                            $('#emp_job_data').empty().html(data);

                        })
                        Swal.fire(
                            'Added!',
                            'Employee Added Successfully!',
                            'success'
                        )
                    }
                },
                error: function(response) {

                    console.log(response);

                }
            });



        });

        $("#empTrain").submit(function(e) {
            e.preventDefault();

            var id = $('#empnotraining').val();
            //  /   alert(id);
            $.ajaxSetup({

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const fd = new FormData(this);

            console.log(fd);

            $.ajax({

                url: 'empTraining',
                method: 'POST',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {

                    if (response.status == 200) {
                        //alert(empno);
                        var empno = $('#empnotraining').val();

                        $.get("{{ URL::to('getTrain') }}" + '/' + empno, function(data) {
                            $('#emp_train_data').empty().html(data);

                        })
                        Swal.fire(
                            'Added!',
                            'Employee Added Successfully!',
                            'success'
                        )
                    }
                },
                error: function(response) {

                    console.log(response);

                }
            });



        });


        $("#empExp").submit(function(e) {
            e.preventDefault();

            var id = $('#empnoexp').val();
            // alert(id);
            $.ajaxSetup({

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const fd = new FormData(this);

            console.log(fd);

            $.ajax({

                url: 'empExp',
                method: 'POST',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {

                    if (response.status == 200) {
                        //alert(empno);



                        var empno = $('#empnoexp').val();

                        $.get("{{ URL::to('empExper') }}" + '/' + empno, function(data) {
                            $('#emp_exp_data').empty().html(data);

                        })

                        Swal.fire(
                            'Added!',
                            'Employee Added Successfully!',
                            'success'
                        )
                    }
                },
                error: function(response) {

                    console.log(response);

                }
            });



        });













        $(document).ready(function() {
            $('#updateorsave').val('new');

            $('#comapnylist').select2();
            $('#comapnylist_of').select2();
            $('#deptList').select2();
            $('#section_no').select2();
            $('#floorList').select2();
            $('#des_id').select2();
            $('#line').select2();
            $('#p_police_station').select2();
            $('#p_district2').select2();
            $('#r_district').select2();
            $('#emp_type').select2();
            $('#grade_id').select2();
            $('#shift_code').select2();
            $('#cal_code').select2();
            $('#opt_no').select2();
            $('#weekly_off').select2();






            $('#emppersonalUpdate').hide();


            $("#empno").on('keyup', function(e) {
                //alert('ss');
                fetAllEmpEduData();
                fetAllEmpCourseData();
                fetAllEmpFamilyData();
                fetchEmpJob();
                fetchTrainData();
                fetchExpData();
            });

        });

        function fetAllEmpEduData() {
            var empno = $('#empnoedu').val();
            //alert(empno);
            $.get("{{ URL::to('getEdu') }}" + '/' + empno, function(data)

                {
                    $('#emp_edu_data').empty().html(data);

                })
        }

        function fetAllEmpCourseData() {
            var empno = $('#empnoshtcourse').val();
            //alert(empno);
            $.get("{{ URL::to('getCourse') }}" + '/' + empno, function(data)

                {
                    $('#emp_course_data').empty().html(data);

                })
        }

        function fetAllEmpCourseData() {
            var empno = $('#empnoshtcourse').val();
            //alert(empno);
            $.get("{{ URL::to('getCourse') }}" + '/' + empno, function(data)

                {
                    $('#emp_course_data').empty().html(data);

                })
        }

        function fetAllEmpFamilyData() {
            var empno = $('#empnoNominee').val();
            //alert(empno);
            $.get("{{ URL::to('getNome') }}" + '/' + empno, function(data)

                {
                    $('#emp_nom_data').empty().html(data);

                })
        }

        function fetchEmpJob() {
            var empno = $('#empnojob').val();

            $.get("{{ URL::to('getJob') }}" + '/' + empno, function(data) {
                $('#emp_job_data').empty().html(data);

            })
        }


    });

    function fetchTrainData() {
        var empno = $('#empnotraining').val();

        $.get("{{ URL::to('getTrain') }}" + '/' + empno, function(data) {
            $('#emp_train_data').empty().html(data);

        })
    }

    function fetchExpData() {
        var empno = $('#empnoexp').val();

        $.get("{{ URL::to('empExper') }}" + '/' + empno, function(data) {
            $('#emp_exp_data').empty().html(data);

        })
    }
    </script>




    <!-- EmpOfficial Depended  List Script -->
    <script>
    $(document).ready(function() {


        // dymmy 

        $(document).on('change', '#comapnylist', function() {

            var comapnyID = $(this).val();

            if (comapnyID) {
                $.ajax({
                    url: '/getEmp/',
                    type: "GET",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data) {

                            $('#deptList').append('<option hidden>Choose Dept</option>');
                            $.each(data, function(key, emp) {

                                var empName = emp.new_empno;

                                //     $('input[name="provision_period"]').val(""+emp.new_empno);
                                $('#provision_period').val(emp.middle_name);
                            });
                        } else {

                        }
                    }
                });
            } else {


            }
        });




        $(document).on('change', '#comapnylist_of', function() {


            var empno = $("#empno").val();


            var comapnyID = $(this).val();
            $('select[name="floor_id"]').empty();
            if (comapnyID) {
                $.ajax({
                    url: '/floorList/' + comapnyID,
                    type: "GET",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            $('#floorList').empty();
                            $('#floorList').append('<option  value="">Select One</option>');
                            $.each(data, function(key, floorList) {
                                $('select[name="floor_id"]').append(
                                    '<option value="' + floorList.floor_id +
                                    '">' + floorList.floor_desc + '</option>');
                            });





                            $.ajax({
                                url: 'empDetailsSearch',
                                method: 'get',
                                data: {
                                    'empno': empno
                                },
                                success: function(data) {

                                    $.each(data, function(key, empdt) {



                                        //emp_official
                                        $.each(empdt.getempofficial,
                                            function(key,
                                                getempofficial) {



                                                $('#floorList').val(
                                                        getempofficial
                                                        .floor_id)
                                                    .change();


                                            });

                                        //emp_location


                                        //emp_education



                                    });
                                },
                                error: function(response) {

                                }
                            });



















                        } else {
                            $('#floor_id').append('<option >No Data</option>');
                        }
                    }
                });
            } else {
                $('#floor_id').append('<option >No Data</option>');
            }
        });

    });
    </script>



</body>



<script type="text/javascript">
$(function() {
    var dateObj = moment(new Date()).format("YYYY-MM-DD");


    console.log(dateObj);

    $("#as_on_date").val(dateObj);
    $("#as_on_date").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true
    });

    $("#id_card_issue").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true
    });
    $("#valid_till").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true
    });
    $("#conform_date").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true
    });
    $("#joining_date").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true
    });
    $("#increment_date").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true
    });
    $("#increment_date").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true
    });
    $("#dob").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        yearRange: '1900:+0',
        onSelect: function(selected, evnt) {



            var dateB = moment($("#dob").val());
            var dateC = moment($("#as_on_date").val());


            var diff = moment($("#dob").val()).diff(dateC, 'milliseconds');
            var duration = moment.duration(diff);
            var age = duration.format().replace("-", "")
            $("#ageDet").val(age);
        }
    });
});

//clear button
$(document).ready(function() {
    // Handle button click event
    $("#clearFieldsBtn").on("click", function() {
        // Clear all input fields
        $('input[type="text"]').val('');
        $('input[type="number"]').val('');
        $('input[type="date"]').val('');

        // Clear the select field
        $('#comapnylist').val('0');
        $('#religion_id').val('');
        $('#status').val('');
        $('#blood_group').val('');



    });
});
//end clear button
</script>


<script>
// JavaScript to preview the selected image
document.getElementById("photo").onchange = function(event) {
    const previewImage = document.getElementById("preview-image");
    const file = event.target.files[0];
    const reader = new FileReader();

    reader.onloadend = function() {
        previewImage.src = reader.result;
    }

    if (file) {
        reader.readAsDataURL(file);
    } else {
        previewImage.src = "";
    }
};


document.getElementById("signature").onchange = function(event) {
    const previewImage = document.getElementById("preview-sign");
    const file = event.target.files[0];
    const reader = new FileReader();

    reader.onloadend = function() {
        previewImage.src = reader.result;
    }

    if (file) {
        reader.readAsDataURL(file);
    } else {
        previewImage.src = "";
    }
};
</script>
<script>
//clear button
$(document).ready(function() {
    // Handle button click event
    $("#clearjob").on("click", function() {
        // Clear all input fields
        $('input[type="text"]').val('');
        $('input[type="number"]').val('');
        $('input[type="date"]').val('');

        // Clear the select field
        $('#empnojob').val('');
        $('#join_as').val('');
        $('#designation').val('');
        $('#join_date').val('');
        $('#work_location').val('');

    });
});

$("#clearacedamy").on("click", function() {
    // Clear all input fields
    $('input[type="text"]').val('');
    $('input[type="number"]').val('');
    $('input[type="date"]').val('');

    // Clear the select field
    $('#empnoedu').val('');
    $('#name_of_ins').val('');
    $('#passed_exam').val('');
    $('#division').val('');
    $('#year').val('');
    $('#marks').val('');
    $('#board').val('');
    $('#subject').val('');

});
$("#clearaddr").on("click", function() {
    // Clear all input fields
    $('input[type="text"]').val('');
    $('input[type="number"]').val('');
    $('input[type="date"]').val('');

    // Clear the select field
    $('#empadempno').val('');
    $('#p_address').val('');
    $('#p_village').val('');
    $('#p_post_office').val('');
    $('#p_police_station').val('');
    $('#p_city').val('');
    $('#p_district2').val('');
    $('#p_pin_code').val('');
    $('#p_phone').val('');
    $('#p_fax').val('');
    $('#p_cperson').val('');
    $('#r_address').val('');
    $('#r_city').val('');
    $('#r_district').val('');
    $('#r_phone').val('');
    $('#r_fax').val('');
    $('#r_mobile').val('');
    $('#r_email').val('');
    $('#r_cperson').val('');

});
//end clear button

// Handle button click event
$("#clearleave").on("click", function() {
    // Clear all input fields
    $('input[type="text"]').val('');
    $('input[type="number"]').val('');
    $('input[type="date"]').val('');

    // Clear the select field
    $('#empnotraining').val('');
    $('#t_title').val('');
    $('#t_conducted_by').val('');
    $('#t_from').val('');
    $('#t_to').val('');
    $('#to_days').val('');
    $('#t_certificate').val('');
    $('#skill_type').val('');


});
$("#clearexp").on("click", function() {
    // Clear all input fields
    $('input[type="text"]').val('');
    $('input[type="number"]').val('');
    $('input[type="date"]').val('');

    // Clear the select field
    $('#empnoexp').val('');
    $('#prv_emp_no').val('');
    $('#organization').val('');
    $('#org_address').val('');
    $('#org_tel').val('');
    $('#designation').val('');
    $('#dept').val('');
    $('#d_from').val('');
    $('#d_to').val('');
    $('#total_years').val('');
    $('#leave_reason').val('');
    $('#last_sal_drawn').val('');


});

$("#clearimg").on("click", function() {
    // Clear all input fields
    $('input[type="text"]').val('');
    $('input[type="number"]').val('');
    $('input[type="date"]').val('');

    // Clear the select field
    $('#empnoimg').val('');
    $('#photo').val('');
    $('#signature').val('');

});

$("#clearnominee").on("click", function() {
    // Clear all input fields
    $('input[type="text"]').val('');
    $('input[type="number"]').val('');
    $('input[type="date"]').val('');

    // Clear the select field
    $('#empnoNominee').val('');
    $('#depd_name').val('');
    $('#depent_name_bangla').val('');
    $('#relationship').val('');
    $('#relation_bn').val('');
    $('#address').val('');
    $('#address_bn').val('');
    $('#d_age').val('');
    $('#male').val('');
    $('#female').val('');
    $('#percentage').val('');

});

$("#clearoff").on("click", function() {
    // Clear all input fields
    $('input[type="text"]').val('');
    $('input[type="number"]').val('');
    $('input[type="date"]').val('');

    // Clear the select field
    $('#empof_id').val('');
    $('#comapnylist_of').val('');
    $('#deptList').val('');
    $('#section_no').val('');
    $('#floorList').val('');
    $('#line').val('');
    $('#des_id').val('');
    $('#emp_type').val('');
    $('#grade_id').val('');
    $('#shift_code').val('');
    $('#cal_code').val('');
    $('#weekly_off').val('');
    $('#opt_no').val('');
    $('#joining_date').val('');
    $('#as_on_join').val('');
    $('#conform_date').val('');
    $('#provision_period').val('');
    $('#lv_cat_id').val('');
    $('#allw_cat_id').val('');
    $('#shift_group').val('');
    $('#appraisal_cal').val('');
    $('#work_ent').val('');
    $('#ot_ent').val('');
    $('#res_ent').val('');
    $('#tran_ent').val('');
    $('#pf_ent').val('');
    $('#tax_ent').val('');
    $('#pro_fund').val('');
    $('#increment_date').val('');
    $('#gross').val('');
    $('#other_allowance').val('');
    $('#bank_name').val('');
    $('#bank_ac_no').val('');
    $('#tin_no').val('');
    $('#tax_deduction').val('');
    $('#dismisal_date').val('');
    $('#resigned_date').val('');
    $('#reason').val('');
    $('#service_book_number').val('');
    $('#ac_no').val('');

});

// Handle button click event
$("#clearshortc").on("click", function() {
    // Clear all input fields
    $('input[type="text"]').val('');
    $('input[type="number"]').val('');
    $('input[type="date"]').val('');

    // Clear the select field
    $('#empnoshtcourse').val('');
    $('#course_name').val('');
    $('#conducted_by').val('');
    $('#c_from').val('');
    $('#total_day').val('');
    $('#certificate').val('');

});

$("#cleartrain").on("click", function() {
    // Clear all input fields
    $('input[type="text"]').val('');
    $('input[type="number"]').val('');
    $('input[type="date"]').val('');

    // Clear the select field
    $('#empnotraining').val('');
    $('#t_title').val('');
    $('#t_conducted_by').val('');
    $('#t_from').val('');
    $('#t_to').val('');
    $('#to_days').val('');
    $('#t_certificate').val('');
    $('#skill_type').val('');


});
</script>


</html>