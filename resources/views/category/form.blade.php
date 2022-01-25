@if(count($errors)>0)
    <div class="alert alert-danger" role="alert">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
    </ul>
    </div>


@endif
<h1>{{$modo}} categoria</h1>
<label for="name">Nombre de la categoria:</label>
<input type="text" class="form-control" name="name" id="name" value="{{ isset($category->name)?$category->name:old('name') }}"></br>
<label for="name">Descripcion:</label>
<input type="text" class="form-control" name="description" id="description" value="{{ isset($category->description)?$category->description:old('description') }}"></br>
<input type="submit" onclick="return confirm('¿Estás seguro que quieres {{$modo}} esta categoría?')" class="btn btn-primary" value="{{$modo}} categoria">
<a href="{{ route('category.index') }}" class="btn btn-success">Regresar</a>
