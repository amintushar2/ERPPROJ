<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department</title>
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

    #in_bengali_edit {
        font-family: 'SutonnyMJ' !important;
    }

    #address_in_bengali_edit {
        font-family: 'SutonnyMJ' !important;
    }

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
                    data-target="#cominsertModal">Add New Company</button>
            </div>
            <span>
                <hr>
            </span>
            <div class="container-fluid">


                <table class="table table-striped" id="datatab">

                    <thead class="bg-dark text-light ">
                        <tr>
                            <th>Comapny </th>
                            <th>Company name</th>
                            <th>IN Bengali</th>
                            <th>Adress </th>
                            <th>Address In Begali</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($getCompanyDetails as $getCompanyDetails)
                        <tr>
                            <td scope="row" id="des_id">{{ $getCompanyDetails->company_id }}</td>
                            <td scope="row" id="designation_name">{{ $getCompanyDetails->company_name }}</td>
                            <td scope="row" id="in_bengali">{{ $getCompanyDetails->in_bengali }}</td>
                            <td scope="row" id="in_short">{{ $getCompanyDetails->address }}</td>
                            <td scope="row" id="in_bengali">{{ $getCompanyDetails->address_bangla }}</td>
                            <td scope="row" id="editd"><button type="button" class="btn btn-primary" id="edit_com"
                                    data-toggle="modal" data-id="{{ $getCompanyDetails->company_id }}"
                                    data-target="#comEditModal"><i class="bi bi-pencil-square"></i>
                                </button>
                                <a id="del_com" data-id="{{ $getCompanyDetails->company_id }}"
                                    class="btn btn-danger btn-info pull-right"><i class="bi bi-trash3-fill"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="cominsertModal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" class="form-group" method="" enctype="multipart/form-data" id="cominsertForm">
                        @csrf
                        <div class="mb-3 row">
                            <label for="line_no" class="col-sm-3 col-form-label">Company No :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="company_id" id="company_id"
                                    placeholder="Company Id" />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="line" class="col-sm-3 col-form-label">Company Name:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="company_name" id="company_name"
                                    placeholder="Company Name" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="line" class="col-sm-3 col-form-label">In Bengali:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="in_bengali" id="in_bengali"
                                    placeholder="in_bengali" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="line_in_bangla" class="col-sm-3 col-form-label">Adress:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="address" id="address"
                                    placeholder="address" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="line_in_bangla" class="col-sm-3 col-form-label">Adress:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="address_in_bengali"
                                    id="address_in_bengali" placeholder="Adress In Bengali" />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="l_group" class="col-sm-3 col-form-label">Telephone :</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="tel" id="tel" placeholder="Telephone" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="l_group" class="col-sm-3 col-form-label">Fax :</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="fax" id="fax" placeholder="Fax" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="l_group" class="col-sm-3 col-form-label">Email :</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="l_group" class="col-sm-3 col-form-label">Logo :</label>
                            <div class="col-sm-8">
                                <input type="file" class="form-control" name="logo" id="logo" placeholder="logo" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="line_insert">Seve changes</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>


    </div>

    <!-- edit line  -->
    <div class="modal fade bd-example-modal-lg" id="comEditModal" tabindex="-1" role="dialog"
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
                    <form action="" class="form-group" method="" id="comeditForm" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 row">
                            <label for="line_no" class="col-sm-3 col-form-label">Company No :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="company_id" id="company_id_edit"
                                    placeholder="Company Id" readonly />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="line" class="col-sm-3 col-form-label">Company Name:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="company_name" id="company_name_edit"
                                    placeholder="Company Name" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="line" class="col-sm-3 col-form-label">In Bengali:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="in_bengali" id="in_bengali_edit"
                                    placeholder="in_bengali" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="line_in_bangla" class="col-sm-3 col-form-label">Adress:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="address" id="address_edit"
                                    placeholder="address" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="line_in_bangla" class="col-sm-3 col-form-label">Adress:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="address_in_bengali"
                                    id="address_in_bengali_edit" placeholder="Adress In Bengali" />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="l_group" class="col-sm-3 col-form-label">Telephone :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="tel" id="tel_edit"
                                    placeholder="Telephone" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="l_group" class="col-sm-3 col-form-label">Fax :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="fax" id="fax_edit" placeholder="Fax" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="l_group" class="col-sm-3 col-form-label">Email :</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" name="email" id="email_edit"
                                    placeholder="Email" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="l_group" class="col-sm-3 col-form-label">Logo :</label>
                            <div class="col-sm-8">
                                <input type="file" class="form-control" name="logo" id="logo_edit" placeholder="logo" />
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




<script src="mainjs/jquery.min.js"></script>

<script type="text/javascript" src="{{ URL::asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }} "></script>
<script type="text/javascript" src="{{ URL::asset('dist/js/adminlte.min.js') }} "></script>
<script src="mainjs/sweetalert2.all.min.js"></script>
<link href="erpcss/sweetalert2.min.css" rel="stylesheet">
<script src="mainjs/moment.min.js" crossorigin="anonymous">
</script>




<script src="mainjs/moment-duration-format.js"></script>
<script src="mainjs/jquery.dataTables.min.js"></script>

<script src="mainjs/dataTables.bootstrap5.min.js"></script>
<script src="mainjs/dataTables.buttons.min.js"></script>
<script src="mainjs/buttons.bootstrap5.min.js"></script>
<script src="mainjs/jszip.min.js"></script>
<script src="mainjs/pdfmake.min.js"></script>
<script src="mainjs/vfs_fonts.js"></script>
<script src="mainjs/buttons.html5.min.js"></script>
<script src="mainjs/buttons.print.min.js"></script>
<script src="mainjs/buttons.colVis.min.js"></script>

<script src="mainjs/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
</script>
<script src="mainjs/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
</script>



<!-- insert line  -->
<script>
$('#insertline').on('click', function(e) {

    e.preventDefault();
    $('#lineinsertModal').modal('show');

});

// insert line


$("#cominsertForm").submit(function(e) {
    e.preventDefault();

    $.ajaxSetup({

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    const fd = new FormData(this);

    console.log(fd);

    $.ajax({

        url: 'cominsert',
        method: 'POST',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
            $('#lineinsertModal').modal('hide');

            $('.modal-backdrop').remove();

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
    });

});




// update line
$(document).on('click', '#edit_com', function(e) {
    e.preventDefault();

    console.log($(this).data('id'));
    var id = $(this).data('id');
    $.ajax({
        method: 'get',
        url: 'comapnydt',
        data: {
            'id': id
        },
        success: function(data) {

            $.each(data, function(key, getCompanyDetails) {
                $('#company_name_edit').val(getCompanyDetails.company_name);
                $('#in_bengali_edit').val(getCompanyDetails.in_bengali);
                $('#address_edit').val(getCompanyDetails.address);
                $('#address_in_bengali_edit').val(getCompanyDetails.address_bangla);
                $('#tel_edit').val(getCompanyDetails.tel);
                $('#fax_edit').val(getCompanyDetails.fax);
                $('#email_edit').val(getCompanyDetails.email);

            });



        },
        error: function(response) {
            console.log(response);
        }
    })


    console.log(id);
    $('#company_id_edit').val(id);

    $('#comEditModal').modal('show');

})


$(document).on('click', '#del_com', function(e) {
    e.preventDefault();
    var id = $(this).data('id');

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
$(document).on('submit', '#comeditForm', function(e) {
    e.preventDefault();

    $.ajaxSetup({

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    const fd = new FormData(this);
    console.log(fd);


    $.ajax({

        url: 'comUpdate',
        method: 'POST',
        data: fd,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
            console.log(response);
            $('#comEditModal').modal('hide');
            $('.modal-backdrop').remove();

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
    });

});
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