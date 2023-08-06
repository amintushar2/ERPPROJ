


<!DOCTYPE html>
<html>
<head>
    <title>Employee Information</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

     {{-- font awesome cdn --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap CSS -->

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    
</head>
<body>
<div class="">

<table class="table" id="maintb">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">CITY </th>
      <th scope="col">****</th>
    </tr>
  </thead>
  <tbody>
  @foreach($city as $city)
    <tr class="">
<td>{{$city->city_id}}</td>
<td>{{$city->city}}</td>
<td><a href='#' class='btn btn-success edit' data-id='{{$city->city_id}}' data-first='{{$city->city}}'>Edit</a></td>
    </tr>
    @endforeach

  </tbody>
</table>

</div>




<div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Edit Member</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
            <form action="{{ URL::to('update') }}" id="editForm">
                <input type="hidden" id="memid" name="id">
                <div class="mb-3">
                    <label for="firstname">Firstname</label>
                    <input type="text" name="firstname" id="firstname" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="lastname">Lastname</label>
                    <input type="text" name="lastname" id="lastname" class="form-control">
                </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>
</body>

<script type="text/javascript" src="{{ URL::asset('plugins/jquery/jquery.min.js') }} ">

</script>
<script>



$(document).on('click', '.edit', function(event){
                event.preventDefault();
                var id = $(this).data('id');
                var firstname = $(this).data('first');
                var lastname = $(this).data('last');
                $('#editmodal').modal('show');
                $('#firstname').val(firstname);
                $('#memid').val(id);
            });
</script>
</html>