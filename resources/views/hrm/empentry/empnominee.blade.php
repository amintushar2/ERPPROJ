
@foreach($famList as $famList)
                        <tr>
                            <td>{{$famList->empno}}</td>
                            <td>{{$famList->depd_name}}</td>
                            <td>{{$famList->relationship}}</td>
                            <td>{{$famList->d_dob}}</td>
                            <td>{{$famList->d_age}}</td>
                            <td>{{$famList->d_sex}}</td>
                            <td>{{$famList->percentage}}</td>
                            <td>{{$famList->address}}</td>
                        </tr>
@endforeach