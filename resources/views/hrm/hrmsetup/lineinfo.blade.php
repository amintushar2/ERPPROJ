<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    aside {
        width: 100px;
        overflow: scroll;
    }
    </style>
    <title>Employee List</title>

    <style>

    </style>
</head>

<body>
    @section('title', 'Page Title')
    @include('topbar.sidebar')

    <div class="container-fluid">
        <div class="content-wrapper">
            <div class="d-grid gap-2 col-4 mx-auto" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-secondary float-left" data-toggle="modal"
                    data-target="#lineinsertModal">Add New Line</button>
            </div>
            <span>
                <hr>
            </span>
            <div class="container-fluid">


                <table class="table table-striped" id="datatab">

                    <thead class="bg-dark text-light ">
                        <tr>
                            <th>LINE_NO</th>
                            <th>LINE_NAME</th>
                            <th>LINE_NAME_IN_BANGLA</th>
                            <th>LINE_GROUP</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($line as $lns)

                        <tr>
                            <td scope="row" id="line_no">{{$lns->line_no}}</td>
                            <td scope="row" id="line">{{$lns->line}}</td>
                            <td scope="row" id="line_in_bangla" style="font-family: 'SutonnyMJ' !important;">
                                {{$lns->line_in_bangla}}</td>
                            <td scope="row" id="l_group">{{$lns->l_group}}</td>
                            <td scope="row">
                                <a href="{{route('destroydata',$lns->line_no)}}"
                                    class="btn btn-danger btn-info pull-right">DELETE</a>
                                <button type="button" class="btn btn-info" id="edit_line" data-toggle="modal"
                                    data-id='{{$lns->line_no}}' data-first='{{$lns->line}}'
                                    data-target="#exampleModalLong">
                                    Edit
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="lineinsertModal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Line</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" class="form-group" method="" id="lineinsertForm">
                        @csrf
                        <div class="mb-3 row">
                            <label for="line_no" class="col-sm-3 col-form-label">Line No :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="line_no_new" id="line_no_new"
                                    placeholder="Line No" />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="line" class="col-sm-3 col-form-label">Line Name:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="line_new" id="line_new"
                                    placeholder="line name" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="line_in_bangla" class="col-sm-3 col-form-label">Line Name In Bengali:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="line_in_bangla_new"
                                    id="line_in_bangla_new" placeholder="line_name_in_bangla" />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="l_group" class="col-sm-3 col-form-label">Line Group :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="l_group_new" id="l_group_new"
                                    placeholder="line Group" />
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="insertSubmmit">Seve changes</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>


    </div>

    <!-- edit line  -->
    <div class="modal fade bd-example-modal-lg" id="lineEditModal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Line</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-group" method="" id="lineeditForm">
                        @csrf
                        <div class="mb-3 row">
                            <label for="line_no" class="col-sm-3 col-form-label">Line No :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="line_no_up" id="line_no_up"
                                    placeholder="Line No" />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="line" class="col-sm-3 col-form-label">Line Name:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="line_up" id="line_up"
                                    placeholder="line name" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="line_in_bangla" class="col-sm-3 col-form-label">Line Name In Bengali:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="line_in_bengali_up" id="line_in_bangla_up"
                                    placeholder="line_name_in_bangla" />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="l_group" class="col-sm-3 col-form-label">Line Group :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="l_group_up" id="l_group_up"
                                    placeholder="line Group" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="line_update">Seve changes</button>
                        </div>

                    </form>

                </div>

            </div>
        </div>


    </div>




</body>





<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- insert line  -->
<script>
$('#insertline').on('click', function(e) {

    e.preventDefault();
    $('#lineinsertModal').modal('show');

});

// insert line

$('#lineinsertForm').on('submit', function(e) {
    e.preventDefault();
    //alert('dd');
    $.ajaxSetup({

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var form = new FormData(this);
    console.log(form);

    $.ajax({
        method: 'post',
        url: 'lineinsert',
        data: form,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {

            if (response.status2 == 200) {

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
    })

});
// update line
$(document).on('click', '#edit_line', function(e) {
    e.preventDefault();

    console.log($(this).data('first'));

    var id = $(this).data('id');
    var first = $(this).data('first');
    $('#line_no_up').val(id);
    $('#line_up').val(first);
    var lneup = $('#line_in_bangla_up').val(lneup);
    var lnupdate = $('#l_group_up').val(lnupdate);

    console.log(id);

    $('#lineEditModal').modal('show');

})
$('#lineeditForm').on('submit', function(e) {
    e.preventDefault();

    $.ajaxSetup({

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    var form = $(this).serialize();
    console.log(form);

    $.ajax({
        type: 'POST',
        url: 'lineUpdate',
        data: form,

        success: function(response) {

            $('#lineEditModal').modal('hide');

            if (response.status2 == 200) {

                Swal.fire(
                    'Added!',
                    'Employee Added Successfully!',
                    'success'
                )
            }
            console.log(response)
        },
        error: function(response) {
            console.log(response);
        }

    })

});
</script>



















<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript" src="{{ URL::asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }} "></script>
<script type="text/javascript" src="{{ URL::asset('dist/js/adminlte.min.js') }} "></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Data Table Script -->


<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
</script>


<script>
$(document).ready(function() {
    var table = $('#datatab').DataTable({

        lengthChange: true,
        buttons: ['csv', 'print', 'excel', 'pdf', 'colvis']
    });

    table.buttons().container()
        .appendTo('#datatab_wrapper .col-md-6:eq(0)');
});
</script>

</html>
