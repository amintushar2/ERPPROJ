<!DOCTYPE html>
<html>
   <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <title>Laravel</title>
       <!-- Fontawesome -->
       <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    
       <!-- Bootstrap -->
       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" >

       <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.0/jquery.min.js"></script>

       @livewireStyles

       <style type="text/css">
       .sorticon{
             visibility: hidden;
             color: darkgray;
       }
       .sort:hover .sorticon{
             visibility: visible;
       }
       .sort:hover{
             cursor: pointer;
       }
       </style>
   </head>
   <body>
<div class="container">
      <div class="row">
            <div class="col mt-5">

            <form action="{{route('auth.check')}}"method="post">

<div class="form-group container">
    
<label for="">Company name</label>
<select name="company_id" tabindex="1"  id="type" class="form-control">
   @foreach($db as $dbs)

<option value="{{$dbs->company_id}}">{{$dbs->company_name}}</option>
@endforeach
</select>

</div>


<div class="container">
    <div class="row">
        <div class="col-sm">
        <label for="">Gate Pass NO.</label>
<input type="text" class="form-control" tabindex="2"  name="pass_no"value="{{old('pass_no')}}" placeholder="Enter Your Password">  


        </div>
   <div class="col-sm">
   <label for="">DATE</label>
<input type="date" class="form-control dates" tabindex="3"  name="date"value="{{old('date')}}" placeholder="Enter Your Password">

   </div>

    </div>

</div>


<div>
                <button wire:click="add">Add</button>
            </div>

</form>







            </div>
      </div>
</div>











        <livewire:gp-pagination />

        @livewireScripts

   </body>
   <script>
      jQuery.extend(jQuery.expr[':'], {
    focusable: function (el, index, selector) {
        return $(el).is('a, button, :input, [tabindex]');
    }
});

$(document).on('keypress', 'input,select', function (e) {
    if (e.which == 13) {
        e.preventDefault();
        // Get all focusable elements on the page
        var $canfocus = $(':focusable');
        var index = $canfocus.index(this) + 1;
        if (index >= $canfocus.length) index = 0;
        $canfocus.eq(index).focus();
    }
});
   </script>
   <script>
    $('.dates').datepicker({
    format: 'dd/mm/yy'
});
</script>
</html>