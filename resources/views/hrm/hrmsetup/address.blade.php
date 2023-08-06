<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
        integrity="sha512-YUkaLm+KJ5lQXDBdqBqk7EVhJAdxRnVdT2vtCzwPHSweCzyMgYV/tgGF4/dCyqtCC2eCphz0lRQgatGVdfR0ww=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
    .text-style:hover {
        text-decoration: underline;
    }
    </style>
    <title>location</title>
</head>

<body style="background-color:rgb(255, 224, 255)">

    <header style="background-color:rgb(94, 21, 94)">

        <div class="container">
            <h3 class="text-center text-white"> Address Setup </h3>
        </div>
    </header>
    <div class="container">
        <div class="tab-contant" id="">

            @if( Session::get('status'))
            <div class="alert alert-success">
                {{Session::get('status')}}
            </div>
            @endif


        </div>
    </div>
    <!-- edit&delete table  -->
    <div class="row justify-content-center">
        <div class="col-5">
            <!-- city table  -->
            <table id="city" class="table table-striped">
                <thead>
                    <th> Name of the city</th>
                    <th>City_Id</th>
                    <th>Action </th>
                </thead>

                <tbody>
                    @foreach($city as $ct)
                    <tr>
                        <td scope="row" id="city">{{$ct->city}}</td>
                        <td scope="row" id="city_id">{{$ct->city_id}}</td>

                        <td scope="row" id="editcity"><button type="submit" class="btn btn-primary edit"
                                data-toggle="modal" data-id="{{$ct->city_id}}" data-first="{{$ct->city}}"
                                data-target="#editmodal">
                                EDIT
                            </button>
                        
                        <button class="btn btn-danger delete-data" data-id="{{$ct->city}}">Delete</button></td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- district table  -->
        <div class="col-5">
            <table id="districtTab" class="table table-striped">
                <thead>
                    <th>District</th>
                    <th>District_id</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach($district as $dis)
                    <tr>
                        <td scope="row" id="district">{{$dis->district}}</td>
                        <td scope="row" id="district_id">{{$dis->district_id}}</td>
                        <td scope="row" id="editdistrict"><button type="submit" class="btn btn-primary edit-district"
                                data-toggle="modal" data-id="{{$dis->district_id}}" data-first="{{$dis->district}}"
                                data-target="#district-Modal" id="edit-District">EDIT</button>
                        <button class="btn btn-danger delete-district"
                                data-id="{{$dis->district}}">Delete</button></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>



    <!-- Edit city  -->

    <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit City</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" class="form-group" method="" id="cityUpdateFrom">
                        @csrf

                        <div class="mb-3 row">
                            <label for="city_id" class="col-sm-3 col-form-label"> City ID: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="city_update_id" id="city_update_id"
                                    placeholder="City id" hidden />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="city" class="col-sm-3 col-form-label"> Name Of The city </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="city_change" id="city_change"
                                    placeholder="Name of the city" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="close"
                                data-dismiss="modal">Close</button>
                            <button type="submit" id="city_change" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- insert city  -->
    <div class="row justify-content-center">
        <div class="col-5">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#cityModal"
                id="insertcity">City</button>
        </div>
        <div class="col-5">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#districtleModal"
                id="insertdistrict">District</button>
        </div>
    </div>

    <div class="modal fade" id="cityModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New city</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="city_id" class="col-form-label"> city_id:</label>
                            <input type="text" class="form-control" id="city_insert_id" name="city_id">
                        </div>
                        <div class="form-group">
                            <label for="city" class="col-form-label">Name of the City:</label>
                            <input type="text" class="form-control" id="city_insert_name" name="city">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="citysave">Send message</button>
                </div>
            </div>
        </div>
    </div>
    <!-- update district  -->
   
    <div class="modal fade" id="district-Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit District</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" class="form-group" method="" id="districtUpdateFrom">
                        @csrf

                        <div class="mb-3 row">
                            <label for="district_id" class="col-sm-3 col-form-label"> District ID: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="district_update_id" id="district_update_id"
                                    placeholder="District ID" hidden />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="district" class="col-sm-3 col-form-label"> Name Of The city </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="district_change" id="district_change"
                                    placeholder="Name of the city" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="close"
                                data-dismiss="modal">Close</button>
                            <button type="submit" id="district_change" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- insert district  -->
    <div class="modal fade" id="districtModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New District</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="district_id" class="col-form-label"> city_id:</label>
                            <input type="text" class="form-control" id="district_insert_id" name="district_id">
                        </div>
                        <div class="form-group">
                            <label for="district" class="col-form-label">Name of the District:</label>
                            <input type="text" class="form-control" id="district_insert_name" name="district">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="districtsave">Send message</button>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>



<script>
// data table
$(document).ready(function() {
    $('#districtTab').DataTable({});
});
$(document).ready(function () {
    $('#city').DataTable();
});

</script>
<script>
    // update city 
$('#cityUpdateFrom').on('submit', function(e) {
    e.preventDefault();

    $.ajaxSetup({

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    var form = $(this).serialize();

    $.ajax({
        type: 'post',
        url: 'cityUpdate',
        data: form,
        success: function(response) {
            alert('Success');
            $('#editmodal').modal('hide');
            console.log(response)
        },
        error: function(response) {
            console.log(response);
        }

    })

});
</script>
<script>
// insert city 
$(document).ready(function() {
    $('#insertcity').on('click', function(e) {
        e.preventDefault();
        $('#cityModal').modal('show');
    });
    $('#citysave').on('click', function(e) {
        e.preventDefault();
        $.ajaxSetup({

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        var city = $('#city_insert_name').val();
        var city_id = $('#city_insert_id').val();
        alert('city');
        $.ajax({
            type: 'POST',
            url: 'cityInsert',
            data: {
                city: city,
                city_id: city_id,
            },
            success: function(response) {
                alert('Success');
            },
            error: function(response) {
                console.log(response);
            }
        })

    });
});
//  delete city 
$(document).on('click', '.delete-data', function(e) {
    e.preventDefault();
    var userURL = 'deletecity'
    var id = $(this).data('id');
    console.log(id);

    if (confirm("Are you sure you want to delete this user?") == true) {
        $.ajax({
            url: 'deletecity/' + id,
            type: 'get',
            dataType: 'json',
            success: function(response) {
                console.log(response)
            }
        });
    }

});


// edit city 

$(document).on('click', '.edit', function(event) {
    event.preventDefault();
    var id = $(this).data('id');
    var cityUPdate = $(this).data('first');

    $('#editmodal').modal('show');
    $('#city_change').val(cityUPdate);
    $('#city_update_id').val(id);
});


$(document).on('click', '#close', function(event) {
    event.preventDefault();
    $('#editmodal').modal('hide');

});
</script>

<!-- update district  -->
<script>
$('#districtUpdateFrom').on('submit', function(e) {
    e.preventDefault();

    $.ajaxSetup({

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    var form = $(this).serialize();

    $.ajax({
        type: 'post',
        url: 'districtUpdate',
        data: form,
        success: function(response) {
            alert('Success');
            $('#editdistrict').modal('hide');
            console.log(response)
        },
        error: function(response) {
            console.log(response);
        }

    })

});
</script>

<script>
// insert district 
$(document).ready(function() {
    $('#insertdistrict').on('click', function(e) {
        e.preventDefault();
        alert('dd');
        $('#districtModal').modal('show');
    });

    $('#districtsave').on('click', function(e) {

        $.ajaxSetup({

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        e.preventDefault();
        var district = $('#district_insert_name').val();
        var district_id = $('#district_insert_id').val();
        alert('district');
        $.ajax({
            type: 'POST',
            url: 'districtInsert',
            data: {
                district: district,
                district_id: district_id,
            },
            success: function(response) {
                alert('Success');
            },
            error: function(response) {
                console.log(response);
            }
        })

    });

});
// delete district 
$(document).on('click', '.delete-district', function(e) {
    e.preventDefault();


    var id = $(this).data('id');
    console.log(id);


    if (confirm("Are you sure you want to delete this user?") == true) {
        $.ajax({
            url: 'deletedistrict/' + id,
            type: 'get',
            dataType: 'json',
            success: function(response) {
                console.log(response);

                //alert(data.success);
                trObj.parents("tr").remove();
            },
            error: function(response) {
                console.log(response);
            }
        });
    }

});

// edit district 
$(document).on('click', '#edit-District', function(event) {
    event.preventDefault();
    var id = $(this).data('id');
    var districtUPdate = $(this).data('first');

    $('#district-Modal').modal('show');
    $('#district_change').val(districtUPdate);
    $('#district_update_id').val(id);
});


$(document).on('click', '#close', function(event) {
    event.preventDefault();
    $('#district-Modal').modal('hide');

});
</script>



</html>