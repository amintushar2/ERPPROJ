<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
    .text-style:hover {
        text-decoration: underline;
    }
    </style>
    <style type="text/css">
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

    #in_bengali {
        font-family: 'SutonnyMJ' !important;
    }
    </style>
    <title>Designation</title>
</head>

<body style="">
    @section('title', 'Page Title')
    @include('topbar.sidebar')
    <div class="container-fluid">
        <div class="content-wrapper">

            @if( Session::get('status'))
            <div class="alert alert-success">
                {{Session::get('status')}}
            </div>
            @endif


            <div class="d-grid gap-2 col-6 mx-auto">
  <button class="btn btn-primary" type="button" data-target="#desinsertModal" data-toggle="modal"d="insertDesignation" >Add Designations</button>
</div>
                <!-- add designation  -->
            







            @if(Session::get('deletef'))
            <div class="alert alert-danger">
                {{Session::get('deletef')}}
            </div>
            @endif
            <div class="container-fluid">
                <table class="table table-striped" id="datatab">

                    <thead class="bg-dark text-light ">
                        <tr>
                            <th>Code</th>
                            <th>Designation Name</th>
                            <th>In Short</th>
                            <th>In Bengali</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($desig as $des)
                        <tr>
                            <td scope="row" id="des_id">{{$des->des_id}}</td>
                            <td scope="row" id="designation_name">{{$des->designation_name}}</td>
                            <td scope="row" id="in_short">{{$des->in_short}}</td>
                            <td scope="row" id="in_bengali">{{$des->in_bengali}}</td>

                            <td scope="row" id="editd">
                                <button type="button" class="btn btn-primary edit_des"
                                    data-toggle="modal" data-id="{{$des->des_id}}"
                                    data-first="{{$des->designation_name}}" data-target="#desEditModal"><i class="bi bi-pencil-square"></i></button>
                                <a data-id="{{$des->des_id}}"id="desig_destroy"
                                    class="btn btn-danger btn-info pull-right"><i class="bi bi-trash3-fill"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>





    <div class="modal fade bd-example-modal-lg" id="desinsertModal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Designation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" class="form-group" method="" id="insertdesignationForm">
                        @csrf
                        <div class="mb-3 row">
                            <label for="des_id" class="col-sm-3 col-form-label">Code :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="des_id_new" id="des_id_new"
                                    placeholder="designation id" />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="designation_name" class="col-sm-3 col-form-label">Designation
                                Name:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="designation_name_new"
                                    id="designation_name_new" placeholder="designation name" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="in_short" class="col-sm-3 col-form-label">In Short:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="in_short_new" id="in_short_new"
                                    placeholder="In short" />
                            </div>

                        </div>
                        <div class="mb-3 row">
                            <label for="in_bengali" class="col-sm-3 col-form-label">In Bengali:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="in_bengali_new" id="in_bengali_new"
                                    placeholder="In Bengali" />
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="desi_save">Seve changes</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>


    </div>

    <!-- edit des  -->

    <div class="modal fade bd-example-modal-lg" id="desEditModal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Designation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" class="form-group" method="" id="editdesignationForm">
                        @csrf
                        <div class="mb-3 row">
                            <label for="des_id" class="col-sm-3 col-form-label">Code :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="des_id_up" id="des_id_up"
                                    placeholder="designation id" />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="designation_name" class="col-sm-3 col-form-label">Designation
                                Name:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="designation_name_up"
                                    id="designation_name_up" placeholder="designation name" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="in_short" class="col-sm-3 col-form-label">In Short:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="in_short_up" id="in_short_up"
                                    placeholder="In short" />
                            </div>

                        </div>
                        <div class="mb-3 row">
                            <label for="in_bengali" class="col-sm-3 col-form-label">In Bengali:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="in_bengali_up" id="in_bengali_up"
                                    placeholder="In Bengali" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="desi_close"data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="desi_update">Seve changes</button>
                        </div>

                    </form>

                </div>

            </div>
        </div>


    </div>
</body>








<script src="mainjs/jquery.min.js"></script>

<script src="mainjs/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }} "></script>
<script type="text/javascript" src="{{ URL::asset('dist/js/adminlte.min.js') }} "></script>
<script src="mainjs/sweetalert2.all.min.js"></script>
<link href="erpcss/sweetalert2.min.css" rel="stylesheet">
<script src="mainjs/moment.min.js" crossorigin="anonymous">
</script>

<script src="mainjs/moment-duration-format.js"></script>
<link rel="stylesheet" type="text/css" href="mainjs\DataTables-1.13.6\css/jquery.dataTables.min.css">
<!-- insert des  -->
<script>
$(document).ready(function() {
    $('#datatab').DataTable();
});


$('#insertDesignation').on('click', function(e) {
    e.preventDefault();
    $('#desinsertModal').modal('show');

});

$('#desi_close').on('click', function(e) {
    e.preventDefault();
    $('#desinsertModal').modal('hide');
    $('.modal-backdrop').remove();

});

// insert Designation

$(document).on('submit', '#insertdesignationForm', function(e) {
    e.preventDefault();
    $.ajaxSetup({

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });



    var form = $('#insertdesignationForm').serialize();
    console.log(form);

    $.ajax({
        type: 'POST',
        url: 'desiinsert',
        data: form,
        success: function(response) {
            $('#desinsertModal').modal('hide');
            $('.modal-backdrop').remove();
            if (response.status2 == 200) {
           


    Swal.fire({
  title: 'Added',
  text: "Desgination Added Successfully!",
  icon: 'success',
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'ok'
}).then((result) => {
  if (result.isConfirmed) {
    location.reload();

  }
})          
                    }

        },
        error: function(response) {
            console.log(response);
        }
    })

});
// update des 
$(document).on('click', '.edit_des', function(e) {
    e.preventDefault();

    console.log($(this).data('first'));

    var id = $(this).data('id');
    var first = $(this).data('first');
    $('#des_id_up').val(id);
    $('#designation_name_up').val(first);
    var desupdate = $('#in_short_up').val(desupdate);
    var desup = $('#in_bengali_up').val(desup);
    console.log(id);

    $('#desEditModal').modal('show');

})
$('#editdesignationForm').on('submit', function(e) {
    e.preventDefault();

    $.ajaxSetup({

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    var form = $(this).serialize();
    console.log(form);

    $.ajax({
        type: 'post',
        url: 'desUpdate',
        data: form,
        success: function(response) {
            alert('Success');
            $('#desEditModal').modal('hide');
            $('.modal-backdrop').remove();

            console.log(response)
        },
        error: function(response) {
            console.log(response);
        }

    })

});




$(document).on('click', '#desig_destroy', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    console.log(id);
    $.ajax({

        url: 'destroydes/' + id,
        method: 'GET',

        success: function(response) {
            console.log('ss' + response);


            if (response.status2 == 200) {

                Swal.fire(
                    'Added!',
                    'Company Profile Delete Successfully!',
                    'success'
                )
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Errorr',
                    html: 'Error Code:' + response +
                        '<br> Company Profile Delete Unsuccessfull',
                })

            }
        },
        error: function(response) {

            Swal.fire({
                icon: 'error',
                title: 'Errorr',
                text: response + '/n Company Profile Delete Unsuccessfull',
            })

        }
    });

})
</script>

</html>