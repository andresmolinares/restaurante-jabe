@extends('layouts.app')

@section('content')
<div class="container">
<form action="{{ route('category.update', $category->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    @include('category.form',['modo'=>'Editar'])

</form>
</div>
@endsection