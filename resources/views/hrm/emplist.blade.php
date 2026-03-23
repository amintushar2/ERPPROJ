<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">

    @include('topbar.sidebar')

    <div class="content-wrapper p-3">

        <div class="content-header">
            <h4>Employee List</h4>
            <hr>
        </div>

        <div class="mb-3">
            <a class="btn btn-secondary" href="{{ route('empnewentry') }}">
                <i class="fas fa-plus"></i> Add New Employee
            </a>
        </div>

        <div class="card">
            <div class="card-body">

                <table class="table table-bordered table-striped" id="datatab">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>EMP NO</th>
                            <th>NEW EMP NO</th>
                            <th>Name</th>
                            <th>Father Name</th>
                            <th>Mother Name</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($empList as $emp)
                            <tr>
                                <td>{{ $emp->empno }}</td>
                                <td>{{ $emp->new_empno }}</td>
                                <td>{{ $emp->empname }}</td>
                                <td>{{ $emp->father_name }}</td>
                                <td>{{ $emp->mother_name }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No Data</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>
        </div>

    </div>

    <footer class="main-footer text-center">
        <strong>FDL ERP</strong>
    </footer>

</div>

<!-- Scripts -->
<script src="{{ URL::asset('mainjs/jquery.min.js') }}"></script>
<script src="{{ URL::asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset('dist/js/adminlte.min.js') }}"></script>
<script src="{{ URL::asset('mainjs/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('mainjs/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ URL::asset('mainjs/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('mainjs/buttons.bootstrap5.min.js') }}"></script>

<script>
$(function () {
    $('#datatab').DataTable({
        responsive: true,
        lengthChange: true,
        autoWidth: false
    });
});
</script>

</body>