@extends('layouts.app')
@section('content')

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
<div class="container">
    <div class="row justify-content-center align-items-center">
        <div class="col-sm-8">
            <h1>Confirmación</h1>
            <p>Tu pedido tiene el codigo {{ $order }}</p>
            <small><p>Será entregado en tu direccion: {{ Auth::user()->address }}</p></small>
        </div>
        {{--Boton con ruta para la vista principal de productos--}}
        <a href="{{ route('clientorder.index') }}" class="btn btn-dark">Ir a ver mis pedidos</a>
    </div>
    <hr width="50%">

    <form action="{{route('rating.send')}}" method="post">
        @csrf
    <div class="row justify-content-center align-items-center">
        <div class="col-sm-8">
        <div class="card">
            <div class="card-header"><b>¡Dejanos saber tu opinión!</b></div>
            <div class="card-body">

                <center>
                <div class="form-check form-check-inline m-2 p-1">
                    <input class="form-check-input" type="radio" name="stars" id="stars" value="1">
                    <label class="form-check-label" for="inlineRadio1">1<i class="fas fa-star"></i></label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="stars" id="stars" value="2">
                    <label class="form-check-label" for="inlineRadio2">2<i class="fas fa-star"></i></label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="stars" id="stars" value="3">
                    <label class="form-check-label" for="inlineRadio3">3<i class="fas fa-star"></i></label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="stars" id="stars" value="4">
                    <label class="form-check-label" for="inlineRadio3">4<i class="fas fa-star"></i></label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="stars" id="stars" value="5">
                    <label class="form-check-label" for="inlineRadio3">5<i class="fas fa-star"></i></label>
                  </div>
                </center>

                  <br\>

                  <div class="form-group row m-2 p-1">
                    <input type="text" class="form-control" name="description" id="description" placeholder="Deja tu comentario" value="">
                  </div>

                  <input type="hidden" id="users_id" value="{{ Auth::user()->id }}">

                  <br\>
                  <div class="d-grid gap-2 m-2 p-1">

                  <input type="submit" class="btn btn-primary btn-lg btn-block" value="Enviar opinión">
                  </div>

                  <center>
                  <small>No es obligatorio dejar tu opinión, sin embargo todas las opiniones nos ayudan a mejorar.</small>
                   </center>
            </div>

        </div>
    </div>
</form>

    </div>



</div>





@endsection
