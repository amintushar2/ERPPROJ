<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- font awesome cdn --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
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

    #line_in_bengali {
        font-family: 'SutonnyMJ' !important;
    }
    </style>
    <title>Line</title>
</head>

<body style="background-color:rgb(255, 224, 255)">

    <header style="background-color:rgb(94, 21, 94)">

        <div class="container">
            <h3 class="text-center text-white"> Line Name </h3>
        </div>
    </header>
    <div class="container">

        @if( Session::get('status'))
        <div class="alert alert-success">
            {{Session::get('status')}}
        </div>
        @endif
        @if( Session::get('deletef'))
        <div class="alert alert-success">
            {{Session::get('deletef')}}
        </div>
        @endif
        <div class="tab-contant" id="">
            <!-- add line -->
            <div class="row justify-content-center">
                <div class="col-5">
                    <button type="submit" id="insertline" class="btn btn-primary" data-toggle="modal"
                        data-target="#lineinsertModal">Add Line</button>
                </div>
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
                <form action="" class="form-group" method="" id="lineeditForm">
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
                                <input type="text" class="form-control" name="line_in_bangla_up"
                                    id="line_in_bangla_up" placeholder="line_name_in_bangla" />
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
                            <button type="submit" class="btn btn-primary" id="line_update">Save changes</button>
                        </div>

                    </form>

                </div>

            </div>
        </div>


    </div>

<!-- line table  -->
    <div class="container">
        <table id="line" class="table table striped">
            <thead>
                <tr>
                    <th>LINE_NO</th>
                    <th>LINE_NAME</th>
                    <th>LINE_NAME_IN_BANGLA</th>
                    <th>LINE_GROUP</th>
                    <th>Action</th>

                </tr>
            </thead>
            @foreach($line as $lns)
            <tbody>
                <tr>
                    <td scope="row" id="line_no">{{$lns->line_no}}</td>
                    <td scope="row" id="line">{{$lns->line}}</td>
                    <td scope="row" id="line_in_bangla">{{$lns->line_in_bangla}}</td>
                    <td scope="row" id="l_group">{{$lns->l_group}}</td>
                    <td scope="row">
                  
                        <button type="button" class="btn btn-primary edit_lineDate"
                                    data-toggle="modal"    data-id='{{$lns->line_no}}' data-first='{{$lns->line}}' data-target="#exampleModalLong">EDIT</button>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
    </div>

</body>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">


<!-- insert line  -->
<script>
$(document).ready(function() {
    $('#line').DataTable({});
    
});

$(document).on('click','.edit_lineDate',function(e){
    e.preventDefault();

})

$('#insertline').on('click', function(e) {

    e.preventDefault();
    $('#lineinsertModal').modal('show');

});

// insert line

$('#lineinsertForm').on('submit',  function(e) {
    e.preventDefault();
    alert('dd');
    $.ajaxSetup({

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var form = $('#lineinsertForm').serialize();
    console.log(form);

    $.ajax({
        type: 'GET',
        url: 'lineinsert',
        data: form,
        cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
        success: function(response) {
           
            console.log(response);

        },
        error: function(response) {
            console.log(response);
        }
    })

}); 
// update line
$(document).on('click', '.edit_line', function(e) {
    e.preventDefault();
alert('f');
    console.log( $(this).data('first'));

    var id = $(this).data('id');
    var first = $(this).data('first');
    $('#line_no_up').val(id);
   $('#line_up').val(first);
  var lneup = $('#line_in_bangla_up').val(lneup);
  var lnupdate= $('#l_group_up').val(lnupdate);

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
        type: 'post',
        url: 'lineUpdate',
        data: form,
        success: function(response) {
            alert('Success');
            $('#lineEditModal').modal('hide');
            console.log(response)
        },
        error: function(response) {
            console.log(response);
        }

    })

});
</script>
</html>