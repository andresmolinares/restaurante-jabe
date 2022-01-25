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
            data.addColumn('string', 'Fecha');
            data.addColumn('number', 'No. ventas');
            data.addRows([
                @foreach ($noventa as $v)
                    ["{{ $v->order_date }}", {{ $v->total }}],
                @endforeach
            ]);

            // Set chart options
            var options = {'title':"Ventas desde {{\Carbon\Carbon::parse($fi)->format('Y-m-d')}} hasta {{\Carbon\Carbon::parse($ff)->format('Y-m-d')}}",
                           'width':900,
                           'height':400};

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
            chart.draw(data, options);
          }
        </script>
      </head>

    <body>
<!--Alertas de redireccionamiento de acciones (Agregar, Editar, Eliminar)-->
<div class="container">

    <!--Fin de alerta-->
<h4><b>REPORTE DE VENTAS POR FECHA</b></h4>

{!! Form::open(['route'=>'report.results', 'method'=>'POST']) !!}
<div class="row">
    <div class="col-12 col-md-3">
        <span>Fecha Inicial: </span>
        <div class="form-group">
            <input type="date" class="form-control" value="{{old('fecha_ini')}}" name="fecha_ini" id="fecha_ini">
        </div>
    </div>

    <div class="col-12 col-md-3">
        <span>Fecha Final: </span>
        <div class="form-group">
            <input type="date" class="form-control" value="{{old('fecha_fin')}}" name="fecha_fin" id="fecha_fin">
        </div>
    </div>

    <div class="col-12 col-md-3 text-center mt-4">

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Consultar</button>
            <a href="{{url('ventas_mes/pdf' . '/' . $fi . '/' . $ff)}}" class="btn btn-success">Descargar PDF</a>
        </div>
    </div>

    <center>
        <div class="col-12 col-md-4 text-center">
            <span>No. ventas: <b> </b></span>
            <div class="form-group">
                <strong>{{ $venta->count() }}</strong>
            </div>
        </div>

        <div class="col-12 col-md-4 text-center">
            <span>Total: <b> </b></span>
            <div class="form-group">
                <strong>${{ $total }} USD</strong>
            </div>
        </div>
    </center>


</div>
{!! Form::close()!!}

<center><div id="chart_div"></div></center>




    <table class="table table-light">
        <thead class="thead-dark">
            <tr>
            <th>Codigo pedido</th>
            <th>Fecha</th>
            <th>Estado</th>
            <th>Pago</th>
        </tr>
        </thead>

        <tbody>
            @foreach($venta as $o)
                <tr>
                    <td scope="row">{{$o->code}}</td>
                    <td>{{$o->order_date}}</td>
                    <td>{{$o->order_status}}</td>

                    <td>${{$o->total_price}} USD</td>
                    {{--
                    <a href="{{route('order.index')}}" class="btn btn-success">
                        Editar estado del pedido
                    </a>
                        --}}

                </tr>
            @endforeach
        </tbody>
    </table>
    {{--{!! $venta->links() !!}--}}
</div>
</body>
</html>

@endsection

@section('scripts')
{!! Html::script('melody/js/data-table.js') !!}
{!! Html::script('melody/js/chart.js') !!}
<script>
        window.onload = function(){
        var fecha = new Date();
        var mes =  fecha.getMonth()+1;
        var dia = fecha.getDate();
        var ano = fecha.getFullYear();
        if(dia<10)
            dia='0'+dia;
        if(mes<10)
            mes='0'+mes
        document.getElementById('fecha_fin').value=ano+"-"+mes+"-"+dia;
    }
</script>
@endsection
