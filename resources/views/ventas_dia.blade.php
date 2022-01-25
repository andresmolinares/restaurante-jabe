@extends('layouts.app')

@section('content')

<html>


<body>

<div class="container">
    <h4><b>VENTAS DE HOY </b></h4>

    <div class="row">
        <div class="col-12 col-md-4 text-center">
            <span>Fecha de consulta: <b> </b></span>
            <div class="form-group">
                <strong>{{ \Carbon\Carbon::today('America/Bogota')->format('d/m/Y') }}</strong>
            </div>
        </div>

        <div class="col-12 col-md-4 text-center">
            <span>Cantidad de registros: <b> </b></span>
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

        <div class="col-12 col-md-4 text-center">

            <div class="form-group">
                <a href="{{route('ventas_dia.pdf')}}" class="btn btn-success">Descargar PDF</a>

            </div>
        </div>

    </div>
    <div id="chart_div"></div>
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
</div>

</body>
</html>





@endsection

