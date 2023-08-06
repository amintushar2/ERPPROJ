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
    <title>Increment Entry</title>
    <style>

    #ui-datepicker-div {
        display: none;
    }

    .select2-selection__rendered {
        line-height: 31px !important;
    }

    .select2-container .select2-selection--single {
        height: 35px !important;
    }

    .select2-selection__arrow {
        height: 34px !important;
    }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    @section('title', 'Page Title')
    @include('topbar.sidebar')
    <!-- {{-- <div class=" p-3"> --}} -->
    <div class="container-fluid">
        <div class="content-wrapper">

            <form action="" method="">
                <div class="container-fluid">
                    <h3 class="text-center">Increment Entry</h3>

                    <hr />
                    <div class="row">
                        {{-- emp no selection --}}
                        <div class="col-md-6">
                            <div class="row p-1">
                                <label for="empno" class="col-sm-5 col-form-label ">Empno :</label>

                                <div class="col-sm-7">
                                    <select class="form-control js-example-responsive" id="empno"
                                        name="empno">
                                        <option value="">Select Employee</option>

                                        @foreach($empnoList as $empnoList)
                                        <option value="{{$empnoList->empno}}">{{$empnoList->empno}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- Joining Date input --}}
                        <div class="col-md-6">
                            <div class="row p-1">
                                <label for="joining_date" class="col-sm-5 col-form-label">Joining Date :</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="joining_date" id="joining_date"
                                        value="{{ old('joining_date') }}"readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Name input --}}
                        <div class="col-md-6">
                            <div class="row p-1">
                                <label for="emp_name" class="col-sm-5 col-form-label">Emp Name :</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="emp_name" id="emp_name"
                                        value="{{ old('emp_name') }}" placeholder="Employee Name"readonly>
                                </div>
                            </div>
                        </div>

                        {{-- Department input --}}
                        <div class="col-md-6">
                            <div class="row p-1">
                                <label for="dept_name" class="col-sm-5 col-form-label">Department Name :</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="dept_name" id="dept_name"
                                        value="{{ old('dept_name') }}"readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{--Designation Name input --}}
                        <div class="col-md-6">
                            <div class="row p-1">
                                <label for="designation_name" class="col-sm-5 col-form-label">Designation Name :</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="designation_name"
                                        id="designation_name" value="{{ old('designation_name') }}"readonly>
                                </div>
                            </div>
                        </div>

                        {{-- Section Name input --}}
                        <div class="col-md-6">
                            <div class="row p-1">
                                <label for="section_name" class="col-sm-5 col-form-label">Section Name :</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="section_name" id="section_name"
                                        value="{{ old('section_name') }}"readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Last Increment Date input --}}
                        <div class="col-md-6">
                            <div class="row p-1">
                                <label for="year" class="col-sm-5 col-form-label">Last Increment Date :</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="lastincre" id="lastincre" placeholder=""readonly>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-2" id="button">
                            <div class="row p-1">
                                <!-- <button class="btn btn-info" type="button" id="action">Action</button> -->
                            </div>
                        </div>
                    </div>

            </form>
            <hr />
            <form action="" method="" id="increment_from">

            <div class="container-fluid">

                <div class="overflow-auto" style="max-width: 5000px; max-height: 250px;">
                    <table width="5000" >
                        <thead class="bg-dark text-light ">
                            <tr class="w-100">
                                <th style="text-align:center">Incr. Date</th>
                                <th style="text-align:center">Empno</th>
                                <th style="text-align:center">EMPNAME</th>
                                <th style="text-align:center">Prev. Designation</th>
                                <th style="text-align:center">Curr. Designation</th>
                                <th style="text-align:center">Prev Ot Ent</th>
                                <th style="text-align:center">Curr Ot Ent</th>
                                <th style="text-align:center">Prev Gross</th>
                                <th style="text-align:center">Incr. Type</th>
                                <th style="text-align:center">Incr Amount</th>
                                <th style="text-align:center">Gross After Incr.</th>
                                <th style="text-align:center">Remarks</th>
                                <th style="text-align:center">Effective Date</th>
                                <th style="text-align:center">Prev Basic </th>
                                <th style="text-align:center">Prev House Rent</th>
                                <th style="text-align:center">Prev Medical</th>
                                <th style="text-align:center">Curr Basic</th>
                                <th style="text-align:center">Curr House Rent</th>
                                <th style="text-align:center">Curr Medical</th>
                            </tr>
                        </thead>
           

                        <tbody>
                                <tr>
                                    <td rowspan="2">
                                        <input type="text" class="form-control w-80" name="incr_date"
                                            id="incr_date" value="{{ old('incr_date') }}" placeholder="YYYY-MM-DD">
                                        </td>
                                    <td rowspan="2">
                                        <input type="text" class="form-control w-100" name="empno"
                                            id="inempno" value="{{ old('empno') }}" placeholder="50255535">
                                        </td>
                                        <td rowspan="2">
                                        <input type="text" class="form-control w-100" name="empname"
                                            id="empname" value="{{ old('empname') }}" >
                                        </td>
                                    <td rowspan="4">
                                        <input type="text" class="form-control w-100"
                                            name="prev_designation" id="prev_designation"
                                            value="{{ old('prev_designation') }}" placeholder=""readonly>
                                        </td>
                                    <td rowspan="2">
                                    <select class="form-select"name="cur_designation"id="cur_designation" aria-label="Default select example">
                                          <option selected >Select One</option>
                                          @foreach($designation as $designation)
                                          <option value="{{$designation->des_id}}" >{{$designation->designation_name}}</option>


                                          @endforeach
                                      </select>
                             </td>
                                    <td rowspan="2"><input type="text" class="form-control w-100"
                                            name="prev_ot_ent" id="prev_ot_ent" value="{{ old('prev_ot_ent') }}"
                                            placeholder="Prev Ot Ent"readonly></td>
                                    <td rowspan="2"><input type="text" class="form-control"
                                            name="cur_ot_ent" id="cur_ot_ent" value="{{ old('cur_ot_ent')}}"
                                            placeholder=""></td>
                                    <td rowspan="2"><input type="number" class="form-control"
                                            name="prev_gross" id="prev_gross" value="{{ old('prev_gross') }}"
                                            placeholder=""readonly></td>
                                    <td rowspan="2">
                                        <select class="form-control "  name="incr_type" id="incr_type">
                                        <option value="Fixed">Fixed</option>
                                        <option value="Percent">Percent</option>
                                        
                                    </select>
                                    </td>
                                    <td rowspan="2"><input type="number" class="form-control"
                                            name="increment_amt" id="increment_amt" value="{{ old('increment_amt') }}"
                                            placeholder=""></td>
                                    <td rowspan="2"><input type="number" class="form-control"
                                            name="cur_gross" id="cur_gross" value="{{ old('cur_gross') }}"
                                            placeholder=""></td>
                                    <td rowspan="2"><input type="text" class="form-control"
                                            name="remark_text" id="remark_text" value="{{ old('remark_text') }}"
                                            placeholder=""></td>
                                    <td rowspan="2"><input type="text" class="form-control"
                                            name="effective_date" id="effective_date"
                                            value="{{ old('effective_date') }}"></td>
                                    <td rowspan="2"><input type="number" class="form-control"
                                            name="prev_basic" id="prev_basic" value="{{ old('prev_basic') }}"
                                            placeholder=""readonly></td>
                                    <td rowspan="2"><input type="number" class="form-control"
                                            name="prev_house_rent" id="prev_house_rent"
                                            value="{{ old('prev_house_rent') }}" placeholder=""readonly>
                                    </td>
                                    <td rowspan="2"><input type="number" class="form-control"
                                            name="prev_medical" id="prev_medical" value="{{ old('prev_medical') }}"
                                            placeholder=""readonly></td>
                                    <td rowspan="2"><input type="number" class="form-control" name="cur_basic"
                                            id="cur_basic" value="{{ old('cur_basic') }}" placeholder=""></td>
                                    <td rowspan="2"><input type="number" class="form-control"
                                            name="cur_house_rent" id="cur_house_rent"
                                            value="{{ old('cur_house_rent') }}" placeholder=""></td>
                                    <td ><input type="number" class="form-control"
                                            name="cur_medical" id="cur_medical" value="{{ old('cur_medical') }}"
                                            placeholder=""></td>
                                </tr>
                        </tbody>
                       
                    </table>
                </div>
                <hr>
                <div class="d-flex justify-content-center">
                <button class="btn btn-success" type="submit" id="insert_btn">Save</button>

                </div>
                </form>

            </div>
            {{-- <hr/>
            <div class="row-md-6 m-3 text-center">
                <button class="btn btn-success" type="submit" id="insert_btn">Save</button>
                <button class="btn btn-info" type="submit" id="submit_btn">Submit</button>
                <button class="btn btn-primary" type="button" id="chk_btn">Query</button>
                <button class="btn btn-danger" type="button">Cancel</button>
            </div> --}}

            <hr />
            <h3 class="text-center">Increment Info List</h3>
            <div class="overflow-auto" style="max-width: 3000px; max-height: 2000px;">
                <hr />
                <table id="example1" class="table table-bordered p-3" style="width:100%">
                    <thead class="bg-dark text-light"width="1000" style="background-color:rgb(94, 21, 94)">
                        <tr>
                            <th style="text-align:center">Incr. Date</th>
                            <th style="text-align:center">Empno</th>
                            <th style="text-align:center">Prev Desig</th>
                            <th style="text-align:center">Curr Desig</th>
                            <th style="text-align:center">Prev Ot Ent.</th>
                            <th style="text-align:center">Curr Ot Ent.</th>
                            <th style="text-align:center">Prev Gross</th>
                            <th style="text-align:center">Incr Type</th>
                            <th style="text-align:center">Incr Amount</th>
                            <th style="text-align:center">Gross After Incr.</th>
                            <th style="text-align:center">Remarks</th>
                            <th style="text-align:center">Effective Date</th>
                            <th style="text-align:center">Prev Basic</th>
                            <th style="text-align:center">Prev House</th>
                            <th style="text-align:center">Prev Medical</th>
                            <th style="text-align:center">Curr Basic</th>
                            <th style="text-align:center">Curr House</th>
                            <th style="text-align:center">Curr Medical</th>
                            <th style="text-align:center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="emp_inc">
                    </tbody>
                </table>



            </div>
        </div>
</body>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->

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
      $('#empno').select2();
      $('#empno').select2();
      $( "#incr_date" ).datepicker(
        {
            dateFormat: "yy-mm-dd",
            changeMonth: true,
          changeYear: true

        }
    );
    $( "#effective_date" ).datepicker(
        {
            dateFormat: "yy-mm-dd",
            changeMonth: true,
          changeYear: true

        }
    );

$('#increment_from').on('submit',function(e){
    e.preventDefault();
    const fd = new FormData(this);
    var formData = $('#increment_from').serialize();


    $.ajax({
    type: 'GET',
    url: '/incrementEntry',

    data: formData,
                

    success: function(response) {

        if (response.status == 200) {

Swal.fire(
    'Added!',
    'Employee Added Successfully!',
    'success'
)
 // Clear all input fields
 $('input[type="text"]').val('');
    $('input[type="number"]').val('');

    $('#emp_inc').empty().html(data);

}       
    }
});

})

    $(document).on('change','#empno', function(e) {

e.preventDefault();

$.ajaxSetup({

    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
var empno = $('#empno').val();
var comId = 'null';
$('#inempno').val(empno);

var data = {
    empno:empno,
        comId:comId
};

console.log(data);
$.ajax({
    type: 'GET',
    url: '/getinEmp',

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
                        $('#designation_name').val(getEmpList.des_name);
                        $('#dept_name').val(getEmpList.dept_name);
                        $('#dept_no').val(getEmpList.dept_no);
                        $('#section_name').val(getEmpList.section_name);
                        $('#section_no').val(getEmpList.section_no);
                        $('#lastincre').val(getEmpList.last_increment_date);
                        var empname = $('#emp_name').val();
      $('#empname').val(empname);
                        
                    });
                } else {}
            }


        });
    }
});
});

$(document).on('change','#empno', function(e) {

e.preventDefault();

$.ajaxSetup({

    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
var empno = $('#empno').val();
var comId = 'null';

var data = {
    empno:empno,
        comId:comId
};

console.log(data);
$.ajax({
    type: 'GET',
    url: '/getprevgross',

    data: data,

    success: function(data) {
        console.log(data);

            
                if (data) {

                    $.each(data, function(key, getEmpList) {
                        console.log(getEmpList);
                        $('#prev_designation').val(getEmpList.des_name);
                        $('#emp_name').val(getEmpList.emp_name);
                        $('#prev_gross').val(getEmpList.gross);
                        $('#prev_house_rent').val(getEmpList.hr_amt);
                        $('#prev_medical').val(getEmpList.mr_amt);
                        $('#prev_basic').val(getEmpList.basic);
                        $('#cur_ot_ent').val('No');
                        $('#prev_ot_ent').val('No');
                        
                        
                    });
                } else {



                }
            


    }
});
});



$(document).on('keyup', '#increment_amt', function(e) {
        e.preventDefault();
        var empId = $('#empno').val();
      

      var  incr_type=$('#incr_type').val();
console.log(incr_type);
if(incr_type=='Fixed'){

var prev_gross= $('#prev_gross').val();
var inc_amount= $('#increment_amt').val();
var cur_gross=parseInt(prev_gross)+parseInt(inc_amount);
 $('#cur_gross').val(cur_gross)

  var current_gross= $('#cur_gross').val()
  var basic =Math.round((parseInt(current_gross)-1850)/1.5);
  $('#cur_basic').val(basic);
  var current_basic=$('#cur_basic').val();
  var homr=Math.round(parseInt(current_basic)/2);
  $('#cur_house_rent').val(homr);
  $('#cur_medical').val('600');
  $('#prev_medical').val('600');
console.log(basic);


}




        $.ajax({
            type: 'GET',
            url: '/tableData/' + empId,
            data: {
                "_token": "{{ csrf_token() }}"
            },
            success: function(data) {


              

            },
            error: function(response) {
                alert('error');
                console.log(response);
            }
        });


    });








</script>

<script>
$(document).ready(function() {
    $(document).on('change', '#empno', function(e) {
        e.preventDefault();

        var empId = $('#empno').val();

        $.ajax({
            type: 'GET',
            url: '/tableData/' + empId,
            data: {
                "_token": "{{ csrf_token() }}"
            },
            success: function(data) {

                $('#emp_inc').empty().html(data);

              

            },
            error: function(response) {
                alert('error');
                console.log(response);
            }
        });


    });
});
</script>

</html>