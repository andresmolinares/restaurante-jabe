@extends('layouts.app')

@section('content')

<!--Panel superior de navegación-->
    <div class="container" style="margin-top: 7px">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/shop">Productos</a></li>
                <li class="breadcrumb-item active" aria-current="page">Carrito</li>
            </ol>
        </nav>
<!--FIN Panel superior de navegación-->

<!--Alertas/avisos-->
        @if(session()->has('success_msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
        @if(session()->has('alert_msg'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session()->get('alert_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $error }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endforeach
        @endif
<!--FIN Alertas/avisos-->

        <div class="row justify-content-center">
            <div class="col-lg-7">
                <br>
                {{--Metodo para traer la cantidad de productos--}}
                @if(\Cart::getTotalQuantity()>0)
                    <h4>{{ \Cart::getTotalQuantity()}} Productos en tu carrito</h4><br>
                @else
                    <h4>No tienes productos en el carrito</h4><br>
                    <a href="{{ route('shop') }}" class="btn btn-dark">Continuar comprando</a>
                @endif

                {{--Panel principal de los productos agregados--}}
                @foreach($cartCollection as $item)
                    <div class="row">
                        <div class="col-lg-3">
                            <img src="imagen/{{ $item->attributes->image }}" class="img-thumbnail" width="200" height="200">
                        </div>
                        <div class="col-lg-5">
                            <p>
                                <b><a href="/shop/{{ $item->attributes->slug }}">{{ $item->name }}</a></b><br>
                                <b>Precio: </b>${{ $item->price }}<br>
                                <b>Sub Total: </b>${{ \Cart::get($item->id)->getPriceSum() }}<br>
                                {{--                                <b>With Discount: </b>${{ \Cart::get($item->id)->getPriceSumWithConditions() }}--}}
                            </p>
                        </div>
                        <div class="col-lg-4">
                            <div class="row">
                                <form action="{{ route('cart.update') }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="form-group row">
                                        <input type="hidden" value="{{ $item->id}}" id="id" name="id">
                                        <input type="number" class="form-control form-control-sm" value="{{ $item->quantity }}"
                                               id="quantity" name="quantity" style="width: 70px; margin-right: 10px;">
                                        <button class="btn btn-secondary btn-sm" style="margin-right: 25px;"><i class="fa fa-edit"></i></button>
                                    </div>
                                </form>
                                <form action="{{ route('cart.destroy') }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ $item->id }}" id="id" name="id">
                                    <button class="btn btn-dark btn-sm" style="margin-right: 10px;"><i class="fa fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <hr>
                @endforeach
                @if(count($cartCollection)>0)
                    <form action="{{ route('cart.clear') }}" method="POST">
                        {{ csrf_field() }}
                        <button class="btn btn-secondary btn-md">Limpiar carrito</button>
                    </form>
                @endif
            </div>

            @if(count($cartCollection)>0)
            <div class="col-lg-5">
                <form action="{{route('pay')}}" method="POST" id="paymentForm">
                    @csrf
                    <input class="form-control" type="hidden" name="value" id="value" value="{{ \Cart::getTotal() }}" readonly="readonly">
                    <input class="form-control" type="hidden" name="currency" id="currency" value="usd" readonly="readonly">
                    <div class="card">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><b>Selecciona la forma de pago:</b></li>
                            <div class="form-group" id="toggler">
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">

                                    @foreach ($paymentPlatforms as $paymentPlatform)
                                        <label class="btn btn-outline-secondary-rounded m-2 p-1"
                                        data-target="#{{ $paymentPlatform->name }}Collapse"
                                        data-toggle="collapse">
                                            <input type="radio" name="payment_platform" value="{{$paymentPlatform -> id}}" required>
                                            <img class="img-thumbnail" src="{{asset($paymentPlatform -> image)}}">
                                        </label>
                                    @endforeach

                                </div>
                                @foreach ($paymentPlatforms as $paymentPlatform)
                                    <div id="{{ $paymentPlatform->name }}Collapse" class="collapse" data-parent="#toggler">
                                        @includeIf('components.'.strtolower($paymentPlatform->name).'-collapse')
                                    </div>
                                @endforeach
                            </div>
                        </ul>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><b>Total: </b>${{ \Cart::getTotal() }}</li>
                        </ul>
                    </div>
                    <br><a href="{{ route('shop') }}" class="btn btn-dark" >Continuar comprando</a>

                    <input class="btn btn-success" type="submit" onclick="return confirm('¿Estás seguro que quieres hacer el pedido?')" value="Pagar">
                    {{--<a href="{{ route('cart.factura') }}" class="btn btn-success" onclick="return confirm('¿Estás seguro que quieres hacer el pedido?')" >Ir a pagar</a>--}}
                </form>

                </div>

            @endif
        </div>
        <br><br>
    </div>
@endsection
