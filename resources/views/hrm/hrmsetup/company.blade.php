<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ URL::asset('plugins/fontawesome-free/css/all.min.css') }}">


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



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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
                                <button type="button" class="btn btn-danger edit_des" data-toggle="modal"
                                    data-id="{{ $getCompanyDetails->company_id }}" data-target="#desEditModal"><i
                                        class="bi bi-trash3-fill"></i>
                                </button>
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





<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

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

            if (response.status == 200) {

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
$('#comeditForm').on('submit', function(e) {
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
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
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
