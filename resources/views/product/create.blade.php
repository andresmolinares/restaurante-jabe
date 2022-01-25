@extends('layouts.app')

@section('content')
<div class="container">

<form action="{{ route('product.index') }}" method="post" enctype="multipart/form-data">
@csrf
@include('product.form',['modo'=>'Crear'])
</form>
</div>
@endsection
