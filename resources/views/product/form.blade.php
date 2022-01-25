@if(count($errors)>0)
    <div class="alert alert-danger" role="alert">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
    </ul>
    </div>


@endif
<h1>{{$modo}} Producto</h1>

<div class="form-group">
    <label for="name">Nombre del producto:</label>
    <input type="text" class="form-control" name="name" id="name" value="{{ isset($product->name)?$product->name:old('name') }}"></br>
</div>

<div class="form-group">
    <label for="description">Descripcion:</label>
    <input type="text" class="form-control" name="description" id="description" value="{{ isset($product->description)?$product->description:old('description') }}"></br>
</div>

<div class="form-group">
    <label for="photo">Foto:</label>
    @if(isset($product->photo))
    <img src="{{asset('imagen').'/'.$product->photo}}" width="100" alt="">
    @endif
    <input type="file" class="form-control" name="photo" id="photo" value="{{ isset($product->photo)?$product->photo:old('photo') }}"></br>
</div>

<div class="form-group">
    <label for="price">Precio (USD):</label>
    <input type="number" class="form-control" name="price" id="price" value="{{ isset($product->price)?$product->price:old('price') }}"></br>
</div>

<div class="form-group">
    <label for="category_id">Categoria:</label>
    <select class="form-control" name="category_id" id="category_id">
        @foreach ($category as $categories)
        <option value="{{ $categories->id }}">{{$categories->name}} </option>
    @endforeach
    </select>

</div>


<input type="submit" class="btn btn-primary" value="{{$modo}} Producto">
<a href="{{ route('product.index') }}" class="btn btn-success">Regresar</a>
