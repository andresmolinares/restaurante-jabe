@extends('layouts.app')

@section('content')
<div class="container">
<form action="{{ route('product.update', $product->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    @include('product.form',['modo'=>'Editar'])

</form>
</div>
@endsection