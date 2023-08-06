@foreach($salaryList as $list)
<tr>
    <td>{{ $list->empno }}</td>
    <td>{{ $list->new_empno }}</td>
    <td>{{ $list->emp_name}}</td>
    <td>{{ $list->des_name }}</td>
    <td>{{ $list->gross }}</td>
    <td>{{ $list->basic }}</td>
    <td></td>
    <td>{{ $list->hr_amt }}</td>
    <td></td>
    <td>{{ $list->convance }}</td>
    <td>{{ $list->food_allowance }}</td>
    <td>{{ $list->tax }}</td>
    <td>{{ $list->emp_grade }}</td>
</tr>
@endforeach
