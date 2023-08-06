<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

                            <td scope="row" id="editd"><button type="button" class="btn btn-primary edit_des"
                                    data-toggle="modal" data-id="{{$des->des_id}}"
                                    data-first="{{$des->designation_name}}" data-target="#desEditModal">EDIT</button>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }} "></script>
<script type="text/javascript" src="{{ URL::asset('dist/js/adminlte.min.js') }} "></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">


<!-- insert des  -->
<script>
$(document).ready(function() {
    $('#datatab').DataTable({});
});


$('#insertDesignation').on('click', function(e) {
    alert('d');
    e.preventDefault();
    $('#desinsertModal').modal('show');

});

$('#desi_close').on('click', function(e) {
    e.preventDefault();
    $('#desinsertModal').modal('hide');
    $('.modal-backdrop').remove();

});

// insert Designation

$(document).on('submit', '#insertDesignation', function(e) {
    e.preventDefault();
    alert('dd');
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
            alert('Success');
            console.log(response);

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
</script>

</html>