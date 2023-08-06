<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
    <style>
    #ui-datepicker-div {
        display: none;
    }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Attendance</title>
</head>

<body>
    @section('title', 'Page Title')
    @include('topbar.sidebar')
    <!-- {{-- <div class=" p-3"> --}} -->
    <div class="container-fluid">
        <div class="content-wrapper">

            <form action="" method="" id="attdfrom">
                @csrf
                <div class="container col-sm-12 p-3">

                    <div class="row">
                        {{-- From input --}}
                        <div class="col-md-6">
                            <div class="row p-1">
                                <label for="from" class="col-sm-4 col-form-label">From :</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="fromDate" id="fromDate"
                                        value="{{ old('fromDate') }}">
                                </div>
                            </div>
                        </div>


                        {{-- To input --}}
                        <div class="col-md-6">
                            <div class="row p-1">
                                <label for="to" class="col-sm-4 col-form-label">To :</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="todate" id="todate"
                                        value="{{ old('todate') }}">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        {{-- In Time input --}}
                        <div class="col-md-6">
                            <div class="row p-1">
                                <label for="in_time" class="col-sm-4 col-form-label">In Time :</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="in_time" id="in_time"
                                        value="{{ old('in_time') }}">
                                </div>
                            </div>
                        </div>


                        {{-- Out Times input --}}
                        <div class="col-md-6">
                            <div class="row p-1">
                                <label for="out_time" class="col-sm-4 col-form-label">Out Time :</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="out_time" id="out_time"
                                        value="{{ old('out_time') }}">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        {{-- From input --}}
                        <div class="col-md-6">
                            <div class="row p-1">
                                <label for="designation_name" class="col-sm-4 col-form-label">Designation :</label>
                                <div class="col-sm-8">
                                    <select class="form-select" id="designation_name" name="designation_name">
                                        {{-- @foreach($empList as $empList)
                                                  <option value="{{$empList->designation_name}}">{{$empList->designation_name}}
                                        </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- To input --}}
                        <div class="col-md-6">
                            <div class="row p-1">
                                <label for="empno" class="col-sm-4 col-form-label">Employee :</label>
                                <div class="col-sm-8">
                                    <select class="form-select" id="empno" name="empno">
                                        @foreach($empList as $empList)
                                        <option value="{{$empList->empno}}">{{$empList->empno}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-sm-2">
                        <button type="button" class="btn btn-success" id="go_btn">Go!</button>
                    </div>

                </div>
            </form>



        <div class="overflow-auto" style="max-width: 100%; max-height: 2200px;">
            <form action="" class="form-group" id="fromsaveData">
                <table id="attn_table" class="table table-bordered table-striped" style="width:100%">
                    <thead class="bg-dark text-light" style="background-color:rgb(94, 21, 94)">
                        <tr>
                            <th>Date</th>
                            <th>NEW EMP ID</th>
                            <th>Emp ID</th>
                            <th>In Time</th>
                            <th>In Time 2</th>
                            <th>Late</th>
                            <th>Out Time</th>
                            <th>Out Time2</th>
                            <th>OT</th>
                            <th>OT2</th>
                            <th>Extra OT</th>
                            <th>Status</th>
                            <th>Status2</th>
                            <th>Late Extra</th>

                        </tr>
                    </thead>

                    <tbody id="table_data">

                    </tbody>

                </table>
                <button class="btn btn-success" type="submit" id="saveData">Save</button>
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

<script>
$(document).ready(function() {
    $('#empno').select2();
});
</script>
<script>
$("#fromDate").datepicker({
    dateFormat: "yy-mm-dd",
    changeMonth: true,
    changeYear: true,
});

$("#todate").datepicker({
    dateFormat: "yy-mm-dd",
    changeMonth: true,
    changeYear: true,
});
</script>
<script>
$("#in_time").timepicker({
    timeFormat: 'h:mm p',
    interval: 60,
    minTime: '8',
    maxTime: '6:00pm',
    // defaultTime: '11',
    startTime: '8:00',
    dynamic: true,
    dropdown: true,
    scrollbar: true,
    showLeadingZero: false
});

$("#out_time").timepicker({
    timeFormat: 'h:mm p',
    interval: 60,
    minTime: '8',
    maxTime: '6:00pm',
    // defaultTime: '11',
    startTime: '8:00',
    dynamic: true,
    dropdown: true,
    scrollbar: true,
    showLeadingZero: false
});
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
    $(document).on('click', '#go_btn', function(e) {
        e.preventDefault();
        // var empId = $('#empno').val();

        // const fd = new FormData(this);
        // console.log(fd);
       
        var fromDate = $('#fromDate').val();
        var todate = $('#todate').val();
        var empId = $('#empno').val();
        var inTime = $('#in_time').val();
        var outTime = $('#out_time').val();

        console.log(fromDate);
        console.log(todate);
        console.log(empId);
        console.log(inTime);
        console.log(outTime);

        $.ajax({
            type: 'GET',
            url: 'attData',
            data: {
                'empno': empId,
                'fromDate': fromDate,
                'todate': todate,
                'in_time': inTime,
                'out_time': outTime
            },
            success: function(data) {
                console.log(data);

                $('#table_data').empty().html(data);
                    $('#attn_table').DataTable();
            },
            error: function(response) {
                alert('error');
                console.log(response);
            }
        });
    });
});
</script>

<script>
$("#fromsaveData").submit(function(e) {
    e.preventDefault();

    var arrData = $('#fromsaveData').serializeArray();

    $.ajaxSetup({

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    console.log(arrData);
    $.ajax({
        type: 'GET',
        url: 'attendsave',
        data: $('#fromsaveData').serializeArray(),

        dataType: 'json',
        success: function(response) {

            console.log(response); //checking data in controller 

            if (response.status == 200) {

                Swal.fire(
                    'Added!',
                    'Attendance Added Successfully!',
                    'success',

                )

            }
        },
        error: function(response) {
            alert('dd');
            console.log(response);

        }
    });
});
</script>

</html>