@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">PEDIDO: </div>

                <div class="card-body">
                    @foreach($order as $o)
                    <b>Pedido No. </b>{{$o->code}}<br/>
                    <b>Nombre del cliente: </b>{{$o->nom_cliente}} {{$o->last_cliente}}<br/>
                    <b>Direccion: </b>{{$o->address}}<br/>
                    <b>Telefono: </b>{{$o->phone_number}}<br/>
                    <b>Estado de la orden: </b>{{$o->order_status}}<br/>
                    <b>Productos: </b>
                    @foreach($products as $p)
                    <ul>

                    <li> {{$p->total_products}} {{$p->name}} (${{$p->price}}) </li>

                    </ul>
                    @endforeach

                    <b>Total pagado: </b>${{$o->total_price}} USD<br/>



                    @endforeach
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <a class="btn btn-primary" href="{{url()->previous()}}">Regresar</a>
                        </div>
                    </div>
                </div>


            </div>




        </div>

    </div>


</div>




@endsection
