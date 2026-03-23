@foreach($itemList as $itemList)
                        <tr>
                            <td>{{$itemList->item_id}}</td>
                            <td>{{$itemList->item_name}}</td>
                            <td>{{$itemList->item_unit}}</td>
                            <td>{{$itemList->price}}</td>
                            <td>{{$itemList->party_name}}</td>
                            <td><img src="{{$itemList->image_loc}}" style="width:100px;height:100px;"></td>
                            <td><button type='button'class="btn btn-primary"><i class="bi bi-pencil"></i></button><span> </span><button type='button'class="btn btn-danger"><i class="bi bi-trash3"></i>
</button></td>

                        </tr>
                        @endforeach