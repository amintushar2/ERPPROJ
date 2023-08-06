
@foreach($tableData as $attData)
<tr>
    <td><input type="text" class="form-control" name="att_date[]" id="att_date" value="{{old('att_date',Illuminate\Support\Carbon::parse($attData->att_date)->format('Y-m-d'))}}" placeholder="{{ $attData->att_date }}"></td>
    <td><input type="number" class="form-control" name="empno_new[]" id="empno_new" value="{{ $attData->empno_new }}" placeholder="{{ $attData->empno_new }}"></td>
    <td><input type="number" class="form-control" name="empno[]" id="empno" value="{{ $attData->empno }}" placeholder="{{ $attData->empno }}"></td>
    <td><input type="text" class="form-control" name="in_time[]" id="in_time" value="{{ old('in_time',Illuminate\Support\Carbon::parse($attData->in_time)->format('h:i:s A'))}}" placeholder="{{ $attData->in_time }}"></td>
    <td><input type="text" class="form-control" name="in_time2[]" id="in_time2" value="{{ old('in_time2',Illuminate\Support\Carbon::parse($attData->in_time2)->format('h:i:s A'))}}" placeholder="{{ $attData->in_time2 }}"></td>
    <td><input type="number" class="form-control" name="late[]" id="late" value="{{ $attData->late }}" placeholder="{{ $attData->late }}"></td>
    <td><input type="text" class="form-control" name="out_time[]" id="out_time" value="{{ old('out_time',Illuminate\Support\Carbon::parse($attData->out_time)->format('h:i:s A'))}}" placeholder="{{ $attData->out_time }}"></td>
    <td><input type="text" class="form-control" name="out_time2[]" id="out_time2" value="{{ old('out_time2',Illuminate\Support\Carbon::parse($attData->out_time2)->format('h:i:s A'))}}" placeholder="{{ $attData->out_time2 }}"></td>
    <td><input type="number" class="form-control" name="othour[]" id="othour" value="{{ $attData->othour }}" placeholder="{{ $attData->othour }}"></td>
    <td><input type="number" class="form-control" name="othour2[]" id="othour2" value="{{ $attData->othour2 }}" placeholder="{{ $attData->othour2 }}"></td>
    <td><input type="number" class="form-control" name="extraot[]" id="extraot" value="{{ $attData->extraot }}" placeholder="{{ $attData->extraot }}"></td>
    <td><input type="text" class="form-control" name="status[]" id="status" value="{{ $attData->status }}" placeholder="{{ $attData->status }}"></td>
    <td><input type="text" class="form-control" name="status2[]" id="status2" value="{{ $attData->status2 }}" placeholder="{{ $attData->status2 }}"></td>
    <td><input type="number" class="form-control" name="late_extra[]" id="late_extra" value="{{ $attData->late_extra }}" placeholder="{{ $attData->late_extra }}"></td>

</tr>


@endforeach
  

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link type="text/css" rel="Stylesheet" href="http://ajax.microsoft.com/ajax/jquery.ui/1.8.6/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    
    <script src="https://unpkg.com/moment-duration-format@2.3.2/lib/moment-duration-format.js"></script>
    
    <link type="text/css" rel="Stylesheet" href="http://ajax.microsoft.com/ajax/jquery.ui/1.8.6/themes/smoothness/jquery-ui.css" />



