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