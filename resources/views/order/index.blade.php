@extends('layouts.app')

@section('content')
<!--Alertas de redireccionamiento de acciones (Agregar, Editar, Eliminar)-->
<div class="container">
    @if(Session::has('mensaje'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ Session::get('mensaje') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

    </div>

    @endif
    <!--Fin de alerta-->
<h4>Lista de pedidos</h4>
    <form action="{{route('order.index')}}" method="GET">
        <div class="form-row">
            <div class="col-sm-4">
                <input type="text" class="form-control" name="text" value="{{$text}}" placeholder="Cedula o No.Pedido">
            </div>
            <div class="col-auto">
                <input type="submit" class="btn btn-primary" value="Buscar">
            </div>

            </div>
    </form>
    <br/>
    <table class="table table-light">
        <thead class="thead-dark">
            <tr>

            <th>Codigo pedido</th>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Estado</th>
            <th>Pago</th>
            <th>Acciones</th>
        </tr>
        </thead>

        <tbody>
            @foreach($order as $o)
                <tr>
                    <td scope="row">{{$o->code}}</td>
                    <td>{{$o->name}}</td>
                    <td>{{$o->order_date}}</td>
                    @if($o->order_status == 'PENDIENTE')
                    <td>
                    <a onclick="return confirm('¿Deseas actualizar el estado del pedido a ENTREGADO?')" class="btn btn-warning" href="{{route('change.status.order', $o->id)}}">{{$o->order_status}} <i class="far fa-clock"></i></a>

                        </td>

                    @elseif ($o->order_status == 'ENTREGADO')
                    <td>
                        <a class="btn btn-success disabled" href="{{route('change.status.order', $o->id)}}">{{$o->order_status}} <i class="fas fa-check"></i></a>

                    </td>

                    @elseif ($o->order_status == 'CANCELADO')
                    <td>
                    <a class="btn btn-danger disabled" href="{{route('change.status.order', $o->id)}}">{{$o->order_status}} <i class="fas fa-times"></i></a>

                    </td>


                    @endif
                    <td>${{$o->total_price}} USD</td>
                    {{--
                    <a href="{{route('order.index')}}" class="btn btn-success">
                        Editar estado del pedido
                    </a>
                        --}}
                    <td>

                    <a href="{{route('order.show', $o->id)}}" class="btn btn-dark">
                        <i class="far fa-eye"></i>  Ver detalle
                    </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {!! $order->links() !!}
</div>
@endsection
