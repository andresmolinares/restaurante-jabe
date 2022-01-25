@extends('layouts.app')

@section('content')
<div class="container">
@if(Session::has('mensaje'))
<div class="alert alert-success alert-dismissible" role="alert">
    {{ Session::get('mensaje') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>

    </div>
@endif


<a href="{{ route('product.create') }}" class="btn btn-success">Crear nuevo producto</a>

<table class="table table-light">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Foto</th>
            <th>Precio</th>
            <th>Categoria</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($product as $products)
        <tr>
            <td scope="row">{{$products->num_pro}}</td>
            <td>{{$products->nom_pro}}</td>
            <td>{{$products->desc_pro}}</td>
            <td>
                <img src="imagen/{{$products->photo}}" width="100" alt="">
            </td>
            <td>${{$products->price}} USD</td>

            <td>{{$products->category}}</td>
            <td>
                <a href="{{route('product.edit', $products->num_pro)}}" class="btn btn-warning">
                    Editar
                </a>

                |
                <form action="{{ route('product.destroy', $products->num_pro) }}" method="post" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <input type="submit" class="btn btn-danger" onclick="return confirm('¿Deseas borrar?')" value="Borrar">
                </form>


            </td>
        </tr>
        @endforeach

    </tbody>
</table>
{!! $product->links() !!}
</div>
@endsection
