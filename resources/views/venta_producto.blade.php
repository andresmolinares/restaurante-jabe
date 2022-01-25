@extends('layouts.app')

@section('content')

<html>
    <head>
          <!--Load the AJAX API-->
          <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
          <script type="text/javascript">

            // Load the Visualization API and the corechart package.
            google.charts.load('current', {'packages':['corechart']});

            // Set a callback to run when the Google Visualization API is loaded.
            google.charts.setOnLoadCallback(drawChart);

            // Callback that creates and populates a data table,
            // instantiates the pie chart, passes in the data and
            // draws it.
            function drawChart() {
              // Create the data table.
              var data = new google.visualization.DataTable();
              data.addColumn('string', 'Producto');
              data.addColumn('number', 'Venta');
              data.addRows([
                  @foreach ($carts as $v)
                      ["{{ $v->producto }}", {{ $v->unidades }}],
                  @endforeach
              ]);

              // Set chart options
              var options = {
                             'width':500,
                             'height':300};

              // Instantiate and draw our chart, passing in some options.
              var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
              chart.draw(data, options);
            }
          </script>
    </head>

    <body>
        <div class="container">
            <h4><b>REPORTE DE VENTAS POR PRODUCTO</b></h4>
            <center><div id="chart_div"></div></center>
            <div class="col-6 col-md-2 text-center">

                <div class="form-group">
                    <a href="{{route('ventas_producto.pdf')}}" class="btn btn-success">Descargar PDF</a>

                </div>
            </div>
            <table class="table table-light text-center">
                <thead class="thead-dark">
                    <tr>
                        <th>PRODUCTO</th>
                        <th>UNIDADES VENDIDAS</th>
                        <th>PRECIO UNITARIO</th>
                        <th>TOTAL VENDIDO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($carts as $cart)
                    <tr>
                        <td>{{ $cart->producto }}</td>
                        <td>{{ $cart->unidades }}</td>
                        <td>${{ $cart->precio_unitario }} USD</td>
                        <td>${{ $cart->total_vendido }} USD</td>
                    </tr>

                    @endforeach
                </tbody>

            </table>

        </div>

    </body>
</html>


@endsection
