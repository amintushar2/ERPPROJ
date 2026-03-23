@foreach($itemList as $itemList)
                        <tr>
                            <td>{{$itemList->item_id}}</td>
                            <td>{{$itemList->item_name}}</td>
                            <td>{{$itemList->item_unit}}</td>
                            <td><input type="text" inputmode="numeric"  class="table-input" name="item_price[]" step="any"  id="item_price" value="{{$itemList->price}}" placeholder="{{$itemList->price}}"></td>
                            <td>{{$itemList->party_name}}</td>
                            <td><img src="{{$itemList->image_loc}}" style="width:100px;height:100px;"></td>
                            <td><button type='button'class="btn btn-primary"><i class="bi bi-pencil"></i></button><span> </span><button type='button'class="btn btn-danger" id="check" data-id="{{$itemList->slno}}"data-first="{{$itemList->id_pk}}"><i class="bi bi-trash3"></i>
</button></td>

                        </tr>
                        @endforeach