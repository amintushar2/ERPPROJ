<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
    <!-- {{-- font awesome cdn --}} -->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link href="erpcss/nunitoFont.css" rel="stylesheet">

    <link rel="stylesheet" href="erpcss/all.min.css" />
    <link rel="stylesheet" href="erpcss/bootstrap-icons.min.css" />

    <link href="erpcss/bootstrap.min.css" rel="stylesheet">
    <script src="mainjs/bootstrap.bundle.min.js"></script>
    <script src="mainjs/demo.js"></script>
    <style>
    .aside {
        overflow: scroll;
    }

    @media only screen and (max-width: 400px) {
        body {
            font-size: 50px;
        }
    }
    </style>
</head>

<body>
    @include('topbar.sidebar')
    <div class="content-wrapper">

        <div class="d-flex justify-content-center">
            <h1 class="justyfy-centre">DASHBOARD</h1>

        </div>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">

            <div class="row d-flex justify-content-center">
                <div class="col-md">
                    <div class="row p-1">
                    <div id="monthly_exp2" style="width: 300px; height: 200px;"></div>

                    </div>
                </div>
                <div class="col-md">
                    <div class="row p-1">
                    <div id="monthly_exp" style="width: 300px; height: 200px;"></div>


                    </div>
                </div>
                <div class="col-md ">
                    <div class="row p-1">
                    <div id="monthly_exp3" style="width: 300px; height: 200px;"></div>

                    </div>
                </div>

            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-md ">
                    <div class="row">
                    <div id="monthly_exp1" style="width: 100%; height: 400px;"></div>

                    </div>
                </div>
              
               

            </div>

            </div>
        </div>


    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark  ">
        <!-- Control sidebar content goes here -->
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
        </div>
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">

        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2014-2023 <a href="#">FDL ERP</a>.</strong> All rights reserved.
    </footer>

    {{-- font awesome cdn --}}

    <script type="text/javascript" src="{{ URL::asset('plugins/jquery/jquery.min.js') }} "></script>
    <script type="text/javascript" src="{{ URL::asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }} "></script>
    <script type="text/javascript" src="{{ URL::asset('mainjs/adminlte.min.js') }} "></script>
    <script type="text/javascript" src="{{ URL::asset('mainjs/jquery.slimscroll.min.js') }} "></script>

    <script type="text/javascript" src="googleChart/loader.js"></script>
    <script type="text/javascript">
    // Load the Visualization API and the corechart package.
    google.charts.load('current', {
        'packages': ['corechart']
    });

    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);

    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
            <?php  if ($empCountData==NULL){
                print_r("No Data") ;
            }else{echo $empCountData;} ?>
        ]);

        // Set chart options
        var options = {
            'title': 'Total Employee',
            'width': 300,
            'height': 200
        };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('monthly_exp'));
        chart.draw(data, options);
    }
    </script>
    <script type="text/javascript">
    // Load the Visualization API and the corechart package.
    google.charts.load('current', {
        'packages': ['corechart']
    });

    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);

    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
            <?php  if ($empATTDData==NULL){
                print_r("No Data") ;
            }else{echo $empATTDData;} ?>
        ]);

        // Set chart options
        var options = {
            'title': 'Total Employee',
            'width': 300,
            'height': 200
        };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('monthly_exp2'));
        chart.draw(data, options);
    }
    </script>

    <script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawVisualization);

    function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
            ['Month', 'Total OverTime'],

            <?php  if ($empOTData==NULL){
                print_r("No Data") ;
            }else{echo $empOTData;} ?>

        ]);

        var options = {
            title: 'Monthly Total OverTime Graph By Yearly',
            vAxis: {
                title: 'Total OverTime'
            },
            hAxis: {
                title: 'Month'
            },
            seriesType: 'bars',
            series: {
                1: {
                    type: 'line'
                }
            }


        };
        var chart = new google.visualization.ComboChart(document.getElementById('monthly_exp1'));
        chart.draw(data, options);
    }
    </script>

</body>



</html>