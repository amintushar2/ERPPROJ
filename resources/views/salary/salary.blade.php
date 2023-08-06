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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <style>
    #ui-datepicker-div {}
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
                    <h3 class="text-center">Salary Entry for Employee</h3>

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

                    <div class="row">
                        <div class="col-md-2 p-3" id="button">
                            <div class="row p-3">
                                <button class="btn btn-info" type="submit" id="sal_action">Action</button>
                            </div>
                        </div>
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