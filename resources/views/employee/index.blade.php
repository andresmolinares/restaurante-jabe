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
<h4>Empleados</h4>
    <form action="{{route('employee.index')}}" method="GET">
        <div class="form-row">
            <div class="col-sm-4">
                <input type="text" class="form-control" name="text" value="{{$text}}" placeholder="Cedula">
            </div>
            <div class="col-auto">
                <input type="submit" class="btn btn-primary" value="Buscar">
            </div>
        </div>
    </form>
    <br/>

    <a href="{{ route('employee.create') }}" class="btn btn-success">Registrar empleado</a>


    <br/>

    <table class="table table-light">
        <thead class="thead-dark">
            <tr>

            <th>Cedula</th>
            <th>Nombre empleado</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
        </thead>

        <tbody>
            @foreach($employee as $e)
                <tr>
                    <td scope="row">{{$e->cedula}}</td>
                    <td>{{$e->user_name}} {{$e->last_name}}</td>
                    <td>{{$e->email}}</td>

                    <td>{{$e->rol_name}}</td>

                    {{--
                    <a href="{{route('order.index')}}" class="btn btn-success">
                        Editar estado del pedido
                    </a>
                        --}}
                        <td>
                            <form action="{{ route('employee.destroy', $e->cod_us) }}" method="GET" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <input type="submit" onclick="return confirm('¿Deseas borrar?')" class="btn btn-danger" value="Borrar">
                            </form>
                        </td>

                </tr>
            @endforeach
        </tbody>
    </table>
    {!! $employee->links() !!}
</div>
@endsection
