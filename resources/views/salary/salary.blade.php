<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- font awesome cdn --}}
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


    <style>
    #ui-datepicker-div {}


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
    </style>

    <title>Salary Entry</title>

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
    <div class="container-fluid">
        <div class="content-wrapper">

            <form action="" method="" id="salaryForm">
                <div class="container col-lg-6 p-3">

                    <hr />
                    {{-- Leave Catogory input --}}
                    <div class="mb-3 row">
                        <label for="company_name" class="col-sm-3 col-form-label ">Company Name : </label>
                        <div class="col-sm-8">
                            <select class="form-select" id="company_idd" name="company_name">
                                @foreach($compList as $company)
                                <option value="{{ $company->company_id }}">{{ $company->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Remarks input --}}
                    <div class="mb-3 row">
                        <label for="sal_date" class="col-sm-3 col-form-label ">Salary Date : </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="sal_date" id="sal_date" placeholder=""
                                value="{{ old('sal_date') }}">
                        </div>
                    </div>

                   


                    <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-info" id="sal_action">Gross sallery Entry
                                                Salary</button>
                                        </div>
                </div>

            </form>

            <div class="overflow-auto" style="max-width: 100%; max-height: 2200px;">
                <table id="sal_table" class="table table-bordered table-striped" style="width:100%">
                    <thead class="bg-dark text-light" style="background-color:rgb(94, 21, 94)">
                        <tr>
                            <th style="width:10px; text-align:left">Empno</th>
                            <th style="width:10px; text-align:center">New Emp Id</th>
                            <th style="width:20px; text-align:center">Name</th>
                            <th style="width:10px; text-align:left">Designation</th>
                            <th style="width:10px; text-align:center">Gross</th>
                            <th style="width:20px; text-align:center">Basic</th>
                            <th style="width:10px; text-align:left">Medical</th>
                            <th style="width:10px; text-align:center">HR</th>
                            <th style="width:20px; text-align:center">Stamp</th>
                            <th style="width:10px; text-align:left">Conv'e</th>
                            <th style="width:10px; text-align:center">Food</th>
                            <th style="width:20px; text-align:center">Tax</th>
                            <th style="width:20px; text-align:center">Grade</th>
                        </tr>
                    </thead>
                    <tbody id="table_data">

                    </tbody>
                </table>
            </div>


         <div class="container col-lg-12 p-3">
                <hr />
                <div class="row-md-6 m-3 text-center">
                    <button class="btn btn-secondary" type="button">Gross Entry</button>
                    <button class="btn btn-success" type="submit" id="save_btn">Save</button>
                    <button class="btn btn-info" type="button">Add</button>
                    <button class="btn btn-danger" type="button">Delete</button>
                    <button class="btn btn-primary" type="button">Query</button>
                    <button class="btn btn-warning" type="button">Exit</button>
                </div>
            </div>
        </div>
    </div>

</body>




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




<script>
$(document).ready(function() {
    $('#company_idd').select2();
});
</script>
<script>
$(document).ready(function() {
    $('#leave').DataTable();
});
</script>

<script>
$("#sal_date").datepicker({
    dateFormat: "yy-mm-dd",
    changeMonth: true,
    changeYear: true,
});
</script>

{{-- <script>
        $(document).ready(function(){
            $(document).on('click','#sal_action',function(e){
                e.preventDefault();

                var companyId = $('#company_idd').val();
                var paydate = $('#sal_date').val();

                // const fd = new FormData(this);

                $.ajax({
                    type: 'GET',
                    url: 'salarydata',
                    data: {
                        'company_id' : companyId,
                        'sal_date' : paydate
                    },
                    success:function(data)
                    {
                        console.log(data);

                        $('#table_data').empty().html(data);
                    },error:function(response){
                        alert('error');
                        console.log(response);
                    }
                });
            });
        });
    </script> --}}

<script>
$("#salaryForm").submit(function(e) {
    e.preventDefault();

    $.ajaxSetup({

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var companyId = $('#company_idd').val();
    var paydate = $('#sal_date').val();

    $.ajax({
        type: 'GET',
        url: 'savedata',
        data: {
            'company_id': companyId,
            'sal_date': paydate
        },

        dataType: 'json',
        complete: function(response) {

            console.log(response);

            if (response.status == 200) {
                fetAllFileData();
            };


        },
        error: function(response) {
            alert('1st');
            console.log(response);

        }
    });
});


function fetAllFileData() {
    var companyId = $('#company_idd').val();

    $.get("{{ URL::to('showdata') }}" + '/' + companyId, function(data)

        {
            $('#table_data').empty().html(data);

        })
}
</script>

</html>