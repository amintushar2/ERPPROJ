<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department</title>
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
</head>

<body>

    @section('title', 'Page Title')
    @include('topbar.sidebar')

    <div class="container-fluid">
        <div class="content-wrapper">

            @if( Session::get('status'))
            <div class="alert alert-success">
                {{Session::get('status')}}
            </div>
            @endif
                <!-- add depertment  -->
                <div class="d-grid gap-2 col-6 mx-auto">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deptinsertModal"
                            id="insertdept">Add Department</button>

                </div>



            <!-- dept table  -->
            <div class="container-fluid">
                <table class="table table-striped" id="datatab">

                    <thead class="bg-dark text-light ">
                        <tr>
                            <th>DEPT_NO</th>
                            <th>DEPT_NAME</th>
                            <th>In_Bengali</th>

                            <th>In_Short</th>
                            <th>Company Name</th>
                            <th>Company ID</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    @foreach($dept as $dp)
                    <tbody>
                        <tr>
                            <td scope="row" id="dept_no">{{$dp->dept_no}}</td>
                            <td scope="row" id="dept_name">{{$dp->dept_name}}</td>
                            <td scope="row" id="in_bengali">{{$dp->in_bengali}}</td>
                            <td scope="row" id="in_short">{{$dp->in_short}}</td>
                            <td scope="row" id="c_name">{{$dp->c_name}}</td>
                            <td scope="row" id="company_id">{{$dp->company_id}}</td>
                            <td scope="row" id="editd"><button type="edit" class="btn btn-primary editDept"
                                    data-toggle="modal" data-id="{{$dp->dept_no}}" data-first="{{$dp->dept_name}}"
                                    data-target="#editmodal">EDIT</button></td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- edit dept  -->

    <div class="modal fade" id="editdeptmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" class="form-group" method="" id="depertmenteditForm">
                        @csrf
                        <div class="mb-3 row">
                            <label for="dept_no" class="col-sm-3 col-form-label" hidden>Code:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="dept_update_no" id="dept_update_no"
                                    placeholder="Department_no" hidden />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="dept_name" class="col-sm-3 col-form-label ">Department Name
                                :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="dept_change_name" id="dept_change_name"
                                    placeholder="Department Name" />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="in_bangali" class="col-sm-3 col-form-label">In Bangali:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="in_bangali_up" id="in_bangali_up"
                                    placeholder="" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="in_short" class="col-sm-3 col-form-label">In Short:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="in_short_up" id="in_short_up"
                                    placeholder="" />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="c_name" class="col-sm-3 col-form-label">Company Name:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="c_name" id="c_name" placeholder="" />
                            </div>
                        </div>

                        <div class="mb-3 row ">
                            <label for="company_id" class="col-sm-3 col-form-label">Company ID:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="company_id" id="company_id"
                                    placeholder="Company ID" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="close"
                                data-dismiss="modal">Close</button>
                            <button type="submit" id="dept_change" class="btn btn-primary">Save
                                changes</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- insert dept  -->
    <div class="modal fade bd-example-modal-lg" id="deptinsertModal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formInsert">
                        @csrf
                        <div class="form-group">
                            <label for="dept_no" class="col-form-label"> Department No:</label>
                            <input type="text" class="form-control" id="dept_insert_no" name="dept_insert_no">
                        </div>
                        <div class="form-group">
                            <label for="dept_name" class="col-form-label">Name of the Department:</label>
                            <input type="text" class="form-control" id="dept_insert_name" name="dept_insert_name">
                        </div>
                        <div class="form-group">
                            <label for="in_bangali" class="col-sm-3 col-form-label">In Bangali:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="in_bangali_insert" id="in_bangali_insert"
                                    placeholder="" />
                            </div>
                            <div class="form-group">
                                <label for="in_short" class="col-sm-3 col-form-label">In Short:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="in_short_insert" id="in_short_insert"
                                        placeholder="type_no" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="c_name" class="col-sm-3 col-form-label">Company Name:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="c_name_insert" id="c_name_insert"
                                        placeholder="" value="	FOUR DESIGN (PVT.) LTD." />
                                </div>
                            </div>

                            <div class="mb-3 row ">
                                <label for="company_id" class="col-sm-3 col-form-label">Company ID:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="company_id_insert"
                                        id="company_id_insert" placeholder="Company ID" value="100" />
                                </div>
                            </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="deptsave">Seve changes</button>
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


<script>
// data table

$(document).ready(function() {
    $('#dept').DataTable();
});


//insertDept
$(document).on('click', '#insertdept', function(e) {
    $('#deptinsertModal').modal('show');

})


// update dept
$(document).on('click', '.editDept', function(e) {
    e.preventDefault();

    console.log($(this).data('id'));

    var id = $(this).data('id');
    var deptUPdate = $(this).data('first');
    $('#dept_update_no').val(id)
    $('#dept_change_name').val(deptUPdate);
    $('#in_bangali_up').val(deptUPdate);
    console.log(id);

    $('#editdeptmodal').modal('show');

})
$('#depertmenteditForm').on('submit', function(e) {
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
        url: 'deptUpdate',
        data: form,
        success: function(response) {
            alert('Success');
            $('#editdeptmodal').modal('hide');
            console.log(response)
        },
        error: function(response) {
            console.log(response);
        }

    })

});


// insert city 
$(document).ready(function() {
    $('#insertdept').on('click', function(e) {
        e.preventDefault();
        alert('dd');
        $('#deptinsertModal').modal('show');
    });
    $(document).on('click', '#deptsave', function(e) {
        e.preventDefault();
        alert('dd');
        $.ajaxSetup({

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });



        var form = $('#formInsert').serialize();
        console.log(form);

        $.ajax({
            type: 'POST',
            url: 'deptentry',
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
});
</script>

</html>