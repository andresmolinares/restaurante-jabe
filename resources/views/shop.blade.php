@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 7px">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shop</li>
            </ol>
        </nav>
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-7">
                        <h4>Productos</h4>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-1 col-md-12">
                        <nav class="text-center">
                            <a href="{{route('shop')}}" class="mx-3 pb-3 link-category d-block d-md-inline selected">Todas</a>

                            @foreach ($categories as $category)
                                <a href="{{ route('shop.category', $category->name) }}" class="mx-3 pb-3 link-category d-block d-md-inline">{{$category->name}}</a>
                            @endforeach
                        </nav>
                    </div>
                </div>

                <hr>
                <div class="row">
                    {{--Ciclo para traer datos de la bd a la vista--}}
                    @foreach($products as $pro)
                    <div class="col-lg-3">
                      <div class="card" style="margin-bottom: 20px; height: auto;">
                        <img src="{{ asset('imagen/'.$pro->photo) }}"
                        class="card-img-top mx-auto"
                        style="height: 150px; width: 150px;display: block;"
                        alt="{{ $pro->photo }}">
                        <div class="card-body">
                          <a href=""><h6 class="card-title">{{ $pro->name }}</h6></a>
                          <p>${{ $pro->price }} USD</p>
                          <form action="{{ route('cart.store') }}" method="POST">
                            {{ csrf_field() }}

                            {{--Datos de la BD--}}

                            <input type="hidden" value="{{ $pro->id }}" id="id" name="id">
                            <input type="hidden" value="{{ $pro->name }}" id="name" name="name">
                            <input type="hidden" value="{{ $pro->price }}" id="price" name="price">
                            <input type="hidden" value="{{ $pro->photo }}" id="img" name="img">

                            <input type="hidden" value="1" id="quantity" name="quantity">
                            <div class="card-footer" style="background-color: white;">
                                  <div class="row">
                                    <button class="btn btn-secondary btn-sm" class="tooltip-test" title="add to cart">
                                        {{--Botón para añadir al carrito--}}
                                        <i class="fa fa-shopping-cart"></i> Añadir al carrito
                                    </button>
                                </div>
                            </div>
                        </form>
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>
            </div>
        </div>
    </div>

@endsection
