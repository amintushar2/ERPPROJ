@foreach($itemList as $itemList)
                        <tr>
                            <td>{{$itemList->id_pk}}</td>
                            <td>{{$itemList->buyer_name}}</td>
                            <td><button type='button' class="btn btn-primary"data-id="{{$itemList->id_pk}}" id="viewDetails">View Details</button></td>

                        </tr>
                        @endforeach