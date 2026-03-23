<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
        integrity="sha512-YUkaLm+KJ5lQXDBdqBqk7EVhJAdxRnVdT2vtCzwPHSweCzyMgYV/tgGF4/dCyqtCC2eCphz0lRQgatGVdfR0ww=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <style>






    .highlighted {
        background-color: #ffffcc;
        /* Change this to your desired highlighting style */
    }

    @media only screen and (max-width: 600px) {
        #item_price {
            width: 40px; // you can also use px here...
        }
    }


    /* Large devices (laptops/desktops, 992px and up) -- This would display the text at 10.0rem on laptops and larger screens */

    @media only screen and (min-width: 992px) {
        #item_price {
            width: 60px; // you can also use px here...
        }
    }


    @media only screen and (min-width: 1366px) {
        #item_price {
            width: 80px; // you can also use px here...
        }


    }

    @media only screen and (min-width: 1440px) {
        #item_price {
            width: 100px; // you can also use px here...
        }
    }

    .select2-selection__rendered {}

    .select2-container .select2-selection--single {
        height: 37px !important;
    }










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
</head>

<body>

    <div class="container-fluid d-flex align-items-center justify-content-center">
        @csrf
        <div class="col-lg-10">
            <h2 class="p-2 text-center">Buyer Wise Accessories List</h2>
            <hr />


            <div class="row">
                <div class="modal-body alert alert-success" id="modalBody">
                    Success Inserterd
                </div>
                {{-- company name input --}}
                <div class="col-md">
                    <div class="row p-1">
                        <label for="buyer_name" class="col-sm-4 col-form-label">Buyer Name :</label>
                        <div class="col-sm-7">
                            <select class="form-select" name="buyer_name" id="buyer_name"
                                aria-label="Default select example">
                                <option selected>Select One</option>
                                @foreach($buyerName as $buyerName)
                                <option value="{{$buyerName->party_id}}">{{$buyerName->party_name}}
                                    ({{$buyerName->party_id}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                {{-- Loan App No input --}}
                <div class="col-md">
                    <div class="row p-1">
                        <label for="date" class="col-sm-4 col-form-label">DATE:</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="entdate" name="date"
                                value="{{ old('price_date') }}">
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="row p-1">
                        <label for="id" class="col-sm-4 col-form-label">ID :</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="id_pk" name="id" value="{{ old('id_pk') }}" readonly>

                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-primary" data-toggle="modal" id="modal1"
                                data-target="#exampleModal">
                                Find
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="">
            <form enctype="multipart/form-data" id="insert_item_dat">

                <div class="row">
                    <div class="col-2">
                        <label for="ITEM_ID" class="col-form-label">ITEM_ID :</label>

                        <select class="form-select" name="item_id" id="item_id" aria-label="Default select example">
                            <option value=""  selected>Select One</option>
                            @foreach($item_dt as $item_dt)
                            <option value="{{$item_dt->item_id}}">{{$item_dt->item_name}}
                                ({{$item_dt->item_id}})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-1">

                        <label for="item_unit" class="col-form-label">Unit :</label>
                        <input type="text" class="form-control" id="item_unit" name="item_unit"
                            value="{{ old('item_unit') }}" disabled>

                    </div>

                    <div class="col-1">

                        <label for="price" class="col-form-label">Price/U</label>
                        <input type="number" class="form-control" id="price" name="price" step="any"
                            value="{{ old('price') }}">
                    </div>
                    <div class="col-3">
                        <label for="image" class="col-form-label">SImage :</label>
                        <input type="file" class="form-control" id="image" name="image" value="{{ old('image') }}">
                    </div>
                    <div class="col-2">
                        <label for="remarks" class="col-form-label">Remarks :</label>
                        <input type="text" class="form-control" id="remarks" name="remarks"
                            value="{{ old('party_id') }}">
                    </div>
                    <div class="col-3">
                        <label for="party_id" class="col-form-label">Supplier Name :</label>
                        <select class="form-select" name="party_id" id="party_id" value="{{ old('party_id') }}"
                            aria-label="Default select example">
                            <option value="" selected>Select One</option>
                            @foreach($supllyer as $supllyer)
                            <option value="{{$supllyer->party_id}}">{{$supllyer->party_name}}
                                ({{$supllyer->party_id}})</option>
                            @endforeach
                        </select>
                    </div>

                </div>




                <hr />



                <div class="row-md-6 m-3 text-center">
                    <button class="btn btn-success" type="submit" id="insert_btn">Add Item</button>
                    <button class="btn btn-info" type="submit" id="print">Print Details</button>
                    <button class="btn btn-danger" type="button">Cancel</button>
                </div>

                <div class="container justify-content-center" style="margin-top : 20px">
                    @if( Session::get('delet'))
                    <div class="alert alert-success">
                        <span class="test"></span>
                    </div>
                    @endif
                    @if(Session::get('deletef'))
                    <div class="alert alert-danger">
                        {{Session::get('deletef')}}
                    </div>
                    @endif

                </div>
            </form>



        </div>
    </div>





    <div class="modal fade bd-example-modal-lg" id="exampleModalLong" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">View List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">



                    <div class="container-fluid">


                        <table class="table table-striped" id="modaldataTab">

                            <thead class="bg-dark text-light ">
                                <tr>
                                    <th>ID</th>
                                    <th>Buyer Name</th>

                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody id="modallistBody">

                            </tbody>
                        </table>
                    </div>






                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeModal" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div class="container">
        <form action="" name="add_item" id="add_item" class="form-inline">
            <table class="table table-striped table-sm table-center align-middle" id="maintb">
                <thead>
                    <tr>
                        <!-- <th>Install No</th>
                        <th>PBBOM</th>
                        <th>Install Amount</th>
                        <th>Install Date</th>
                        <th>PBEOM</th>
                        <th>Pay Date</th>
                        <th>Status</th>
                        <th>Action</th> -->
                    </tr>
                </thead>
                <tbody>

                </tbody>

        </form>

    </div>



    <span>
        <hr>
    </span>
    <div class="container-fluid">


        <table class="table table-striped" id="datatab">

            <thead class="bg-dark text-light ">
                <tr>
                    <th scope="col">Item Id</th>
                    <th scope="col">Item Name</th>
                    <th scope="col">Unit</th>
                    <th scope="col">Price</th>
                    <th scope="col">Supplier</th>
                    <th scope="col">Image</th>
                    <th scope="col">Action</th>

                </tr>
            </thead>
            <tbody id="memberBody">

            </tbody>
        </table>
    </div>
</body>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<link type="text/css" rel="Stylesheet"
    href="http://ajax.microsoft.com/ajax/jquery.ui/1.8.6/themes/smoothness/jquery-ui.css" />
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>




<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
</script>

<script src="/arrowTable/dist/arrow-table.js"></script>

<script>
$(document).ready(function() {

    $(document).on('click', '#viewDetails', function(e) {

        e.preventDefault();
        $("#modalBody").hide();

        var id = $(this).data('id');



        $.ajax({
            url: '/getDetails/' + id,
            method: 'get',
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {
                console.log(data)
                if (data) {

                    $.each(data, function(key, buyList) {
                        // console.log(buyList);
                        $('#id_pk').val(buyList.id_pk);
                        $('#buyer_name').val(buyList.buyer_id).change();
                        $('#entdate').val(buyList.price_date);
                        $('#exampleModalLong').modal('hide');
                        if ($('#id_pk').val() !== '') {
                            var id_pk = $('#id_pk').val();
                            //console.log('dddsafjk' + id_pk);

                            $.get("{{ URL::to('item_list/') }}" + '/' + id_pk,
                                function(data) {
                                    $('#memberBody').empty().html(data);

                                });

                        }


                    });
                } else {

                }

            },
            error: function(response) {
                console.log(response);
            }

        });
    })


    $('#modal1').on('click', function(e) {
        $.get("{{ URL::to('item_list/') }}", function(data) {
            $('#modallistBody').empty().html(data);

        })
        $('#exampleModalLong').modal('show');
        $('#modaldataTab').DataTable({
            "bPaginate": true,
            "bAutoWidth": true,
            "bProcessing": true,
            "pageLength": 10,
            "fixedHeader": true,
            "bDestroy": true,
        });



    });


    $('#closeModal').on('click', function(e) {

        $('#exampleModalLong').modal('hide');

    });



    $("#modalBody").hide();

    $('#buyer_name').select2();
    $('#party_id').select2();
    $('#item_id').select2();
    $("#entdate").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true

    });

});
$(document).ready(function() {
    $('#print').on('click', function(e) {
        e.preventDefault();
        var id_pk = $('#id_pk').val();


        window.open('pdfview/' + '' + id_pk, '_blank', 'width=1300,height=700');
        return false;



    });

    $('#item_id').on('change', function(e) {
        var item_id = $('#item_id').val();
        console.log($('#item_id').children("option:selected").text());
        //  var selectedCountry = $(this).children("option:selected").text();  
        // alert ("You have selected the country - " + selectedCountry);  
        e.preventDefault();
        $.ajax({
            type: 'get',
            url: 'item_gat/' + item_id,
            contentType: false,
            processData: false,
            dataType: 'json',
            data: {
                "_token": "{{ csrf_token() }}"
            },
            success: function(data) {
                console.log(data);

                $.each(data, function(key, item_dt) {
                    // console.log(item_dt.unit_id);
                    $('#item_unit').val(item_dt.unit_name);






                });


            },
            error: function(response) {
                //  alert('error');
                console.log(response);
                // Swal.fire({
                //     icon: 'errorr',
                //     title: 'Errorr',
                //     text: response.responseJSON.message,
                // })

            }
        });

    });

});




$(document).ready(function() {
    $.ajaxSetup({

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#insert_item_dat').submit(function(e) {
        e.preventDefault();
        $("#modalBody").hide();

        var id = $('#id_pk').val();
        var buyer_name = $('#buyer_name').val();
        var price_date = $('#entdate').val();
        console.log(price_date);
        if (id == '') {
            $.ajax({
                type: 'post',
                url: 'storeget',
                data: {
                    'buyer_name': buyer_name,
                    'price_date': price_date,

                },
                success: function(response) {
                    console.log(response);
                    $('#id_pk').val(response.loan_nooo);
                    console.log(response);

                    if ($('#id_pk').val() !== '') {

                        var id_pk = $('#id_pk').val();
                        console.log('dd' + id_pk);
                        const fd = new FormData();
                        console.log(fd);

                        var files = $('#image')[0].files;
                        if (files.length > 0) {

                            console.log(fd);
                        }
                        console.log(response);

                        fd.append('id_pk', $('#id_pk').val());
                        fd.append('item_unit', $('#item_unit').val());
                        fd.append('item_id', $('#item_id').val());
                        fd.append('item_name', $('#item_id').children("option:selected")
                            .text());
                        fd.append('price', $('#price').val());
                        fd.append('party_id', $('#party_id').val());
                        fd.append('image', $('input[type=file]')[0].files[0]);
                        $.ajax({
                            type: 'post',
                            url: 'storeitmdt',
                            data: fd,
                            enctype: 'multipart/form-data',
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                $("#modalBody").show();
                                fetAllFileData();

                         //       $('input[type="number"]').val('');
      //  $('input[type="date"]').val('');
        $('#item_id').val('').change();
        $('#party_id').val('').change();
      




                                document.getElementById('insert_item_dat')
                                    .reset();
                                console.log(response);

                            },
                            error: function(response) {
                                //  alert('error');
                                console.log(response);
                                // Swal.fire({
                                //     icon: 'errorr',
                                //     title: 'Errorr',
                                //     text: response.responseJSON.message,
                                // })

                            }
                        });







                    }
                },
                error: function(response) {
                    //  alert('error');
                    console.log(response);
                    // Swal.fire({
                    //     icon: 'errorr',
                    //     title: 'Errorr',
                    //     text: response.responseJSON.message,
                    // })

                }
            });

        } else {
            var id_pk = $('#id_pk').val();
            const fd = new FormData();
            // console.log(fd);

            var files = $('#image')[0].files;
            if (files.length > 0) {

                console.log(fd);
            }
            fd.append('id_pk', $('#id_pk').val());
            fd.append('item_unit', $('#item_unit').val());
            fd.append('item_id', $('#item_id').val());
            fd.append('item_name', $('#item_id').children("option:selected").text());
            fd.append('price', $('#price').val());
            fd.append('party_id', $('#party_id').val());
            fd.append('image', $('input[type=file]')[0].files[0]);
            $.ajax({
                type: 'post',
                url: 'storeitmdt',
                data: fd,
                enctype: 'multipart/form-data',
                contentType: false,
                processData: false,
                success: function(response) {

                    if (response.success == 'success') {
                        $("#modalBody").show();

                        fetAllFileData();
                     //   $('input[type="text"]').val('');
       // $('input[type="number"]').val('');
        //$('input[type="date"]').val('');
        $('#item_id').val('').change();
        $('#party_id').val('').change();

        // Clear the select field
   
                        document.getElementById('insert_item_dat').reset();

                        console.log(response);
                    } else {
                        alert('eee')
                    }


                },
                error: function(response) {
                    //  alert('error');
                    console.log(response);
                    // Swal.fire({
                    //     icon: 'errorr',
                    //     title: 'Errorr',
                    //     text: response.responseJSON.message,
                    // })

                }
            });

        }

    });
    fetAllData();

    function fetAllFileData() {
        var id_pk = $('#id_pk').val();
        console.log('dddsafjk' + id_pk);

        $.get("{{ URL::to('item_list/') }}" + '/' + id_pk, function(data) {
            $('#memberBody').empty().html(data);

        })


    }

    function fetAllData() {
        var id_pk = $('#id_pk').val();
        //console.log('dddsafjk' + id_pk);

        $.get("{{ URL::to('item_list/') }}", function(data) {
            $('#modallistBody').empty().html(data);

        })


    }

});



$(document).ready(function() {
    $("#item_price").on("focus", function() {
        $("#item_price").on("keydown", function(event) {
            if (event.keyCode === 38 || event.keyCode === 40) {
                event.preventDefault();
            }
        });
    });

});







$(document).on('click', '#check', function(e) {

    e.preventDefault();

    var id = $(this).data('id');
    var first = $(this).data('first');

    alert(id + " / " + first);

    $.ajax({
        url: '/delete/',
        method: 'get',
        data: {
            'id': id,
            'first': first
        },
        success: function(data) {
            console.log(data)
            if (data) {

                $.each(data, function(key, buyList) {
                    // console.log(buyList);
                    $('#id_pk').val(buyList.id_pk);
                    $('#buyer_name').val(buyList.buyer_id).change();
                    $('#entdate').val(buyList.price_date);
                    $('#exampleModalLong').modal('hide');
                    if ($('#id_pk').val() !== '') {
                        var id_pk = $('#id_pk').val();
                        //console.log('dddsafjk' + id_pk);

                        $.get("{{ URL::to('item_list/') }}" + '/' + id_pk,
                            function(data) {
                                $('#memberBody').empty().html(data);

                            });

                    }


                });
            } else {

            }

        },
        error: function(response) {
            console.log(response);
        }

    });
})
$('#datatab').arrowTable(
    ['left', 'right', 'up', 'down']
);





$(document).ready(function () {
            // Add an input event listener to the number input field
            $('#item_price').on('input', function () {
                // Get the input value
                var inputValue = $(this).val();
                
                // Remove any non-numeric characters using a regular expression
                var numericValue = inputValue.replace(/[^0-9]/g, '');
                
                // Update the input field with the cleaned numeric value
                $(this).val(numericValue);
            });
        });






</script>


</html>
























<!-- 


<!DOCTYPE html>
<html lang="en">














<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>My Website</title>

    <link rel="icon" href="./favicon.ico" type="image/x-icon">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
        integrity="sha512-YUkaLm+KJ5lQXDBdqBqk7EVhJAdxRnVdT2vtCzwPHSweCzyMgYV/tgGF4/dCyqtCC2eCphz0lRQgatGVdfR0ww=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>


        <style type="text/css">
    tfoot {
     display: table-header-group;
}
</style>

</head>

<body>
    <div class="container">
        <div>
            @if( Session::get('status'))
            <div class="alert alert-success">
                {{Session::get('status')}}
            </div>
            @endif
            @if(Session::get('failed'))
            <div class="alert alert-denger">
                {{Session::get('failed')}}
            </div>
            @endif
        </div>

        @if ($message = Session::get('success'))
    <div class="success">
        <strong>{{ $message }}</strong>
    </div>
@endif

<form action="{{ url('storeget') }}" method="get" enctype="multipart/form-data">
    @csrf
    <p>
        <input type="file" name="profile_image" />
    </p>
    <button type="submit" name="submit">Submit</button>
</form>

</div>







</body>

</html> -->