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

<!--Botón de Crear-->
<a href="{{ route('category.create') }}" class="btn btn-success">Crear nuevo catalogo</a>
<!--Fin de botón crear-->

<!--Tabla para listar catalogos-->
<table class="table table-light">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($category as $categories)
        <tr>
            <td scope="row">{{$categories->id}}</td>
            <td>{{$categories->name}}</td>
            <td>{{$categories->description}}</td>
            <td>
                <a href="{{route('category.edit', $categories)}}" class="btn btn-warning">
                    Editar
                </a>
                 
                |
                <form action="{{ route('category.destroy', $categories) }}" method="post" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <input type="submit" class="btn btn-danger" onclick="return confirm('¿Deseas borrar?')" value="Borrar">
                </form>


            </td>
        </tr>
        @endforeach

    </tbody>
</table>
<!--Fin Tabla para listar catalogos-->
{!! $category->links() !!}
</div>
@endsection