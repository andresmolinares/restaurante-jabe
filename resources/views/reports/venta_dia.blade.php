<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/estilo_pdf.css') }}">
</head>
<body>
    <header>
        <br>
        <p><strong>Restaurant JABE</strong></p>
    </header>
    <main>
        <div class="container">
            <h5 style="text-align:center"><strong><b>Ventas de hoy: {{\Carbon\Carbon::today('America/Bogota')->format('d/m/Y')}}</b></strong></h5>


            <div class="row">
                <div class="col-12 col-md-3 text-center">
                    <span>Total de ventas: <b> </b></span>
                    <div class="form-group">
                        <strong>${{ $total }} USD</strong>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 text-center">
                <span>No. Ventas: <b> </b></span>
                <div class="form-group">
                    <strong>{{ $venta->count() }}</strong>
                </div>
            </div>

        <table class="table table-striped text-center">
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
    </main>


</body>
</html>
