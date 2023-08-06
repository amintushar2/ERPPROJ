<!doctype html>
<html lang="en">

<head>
    <title>Employee Information</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link type="text/css" rel="Stylesheet" href="http://ajax.microsoft.com/ajax/jquery.ui/1.8.6/themes/
smoothness/jquery-ui.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style type="text/css">

    </style>
    <style type="text/css">
    .text-style:hover {
        text-decoration: underline;
    }

    label {
        font-size: 10px;

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

    #b_name {
        font-family: 'SutonnyMJ' !important;
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
                    <div class="nav nav-tabs position-fix top-0 start-0" id="nav-tab" role="tablist"
                        style="background-color: rgb(163, 34, 163)">
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







                <div class="tab-content p-15" id="nav-tabContent" style="width:inline-block">

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




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <script type="text/javascript" src="{{ URL::asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }} "></script>
    <script type="text/javascript" src="{{ URL::asset('dist/js/adminlte.min.js') }} "></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script type="text/javascript">
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


    $('#find_emp').click(function(e) {
        e.preventDefault();
        var empno = $("#empno").val();

        console.log(empno);
        var url = 'empnewentryfind'



        $.ajax({
            url: url,
            method: 'get',
            data: {
                'search_emp': empno
            },
            success: function(data) {


                // window.location.replace(url);
                //alert(url+'?search_emp='+empno);
                window.location.replace(url + '?search_emp=' + empno);
            },
            error: function(response) {

            }

        })

    });
    $(function() {



        $("#emppersonalSave2").submit(function(e) {
            e.preventDefault();

            $.ajaxSetup({

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const fd = new FormData(this);

            console.log(fd);

            $.ajax({

                url: 'emppersonalsave',
                method: 'POST',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {

                    if (response.status == 200) {

                        Swal.fire(
                            'Added!',
                            'Employee Added Successfully!',
                            'success'
                        )
                    }
                },
                error: function(response) {

                    console.log(response);

                 $('#massege').html(response.responseJSON.errors.empno);
                   console.log(response.responseJSON.errors);

                }
            });

        });


        $("#empofficialSave").submit(function(e) {
            e.preventDefault();
            var id = $('#empof_id').val();
            alert(id);
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






        $("#empadressSave").submit(function(e) {
            e.preventDefault();
            var id = $('#empadempno').val();
            alert(id);
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
            alert(id);
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
            alert(id);
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
            alert(id);
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
            alert(id);
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
            alert(id);
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
            alert(id);
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



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- EmpOfficial Depended  List Script -->
    <script>
    $(document).ready(function() {

        $(document).on('change', '#comapnylist', function() {
            console.log(document);
            $('select[name="dept_no"]').empty();

            var comapnyID = $(this).val();

            if (comapnyID) {
                $.ajax({
                    url: '/getDept/' + comapnyID,
                    type: "GET",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            $('#dept_no').empty();
                            $('#dept_no').append('<option hidden>Choose Dept</option>');
                            $.each(data, function(key, deptList) {
                                console.log(deptList);

                                $('select[name="dept_no"]').append(
                                    '<option value="' + deptList.dept_no +
                                    '">' + deptList.dept_name + " Id : " +
                                    deptList.dept_no + '</option>');
                            });
                        } else {
                            $('select[name="dept_no"]').append('<option >No Data</option>');
                        }
                    }
                });
            } else {
                $('select[name="dept_no"]').append('<option >No Data</option>');
            }
        });

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




        $(document).on('change', '#comapnylist', function() {
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
                            $('#floor_id').empty();
                            $('#floor_id').append('<option hidden>Choose Floor</option>');
                            $.each(data, function(key, floorList) {
                                $('select[name="floor_id"]').append(
                                    '<option value="' + floorList.floor_id +
                                    '">' + floorList.floor_desc + '</option>');
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<link type="text/css" rel="Stylesheet"
    href="http://ajax.microsoft.com/ajax/jquery.ui/1.8.6/themes/smoothness/jquery-ui.css" />
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" crossorigin="anonymous">
</script>

<script src="https://unpkg.com/moment-duration-format@2.3.2/lib/moment-duration-format.js"></script>

<link type="text/css" rel="Stylesheet"
    href="http://ajax.microsoft.com/ajax/jquery.ui/1.8.6/themes/smoothness/jquery-ui.css" />

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
            $("#age").val(age);
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
    $('#company_id').val('');
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

</html>