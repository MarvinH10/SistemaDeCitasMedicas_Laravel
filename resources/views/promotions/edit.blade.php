@extends('layouts.panel')

@section('content')
  <div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0">Editar promoción</h3>
        </div>
        <div class="col text-right">
          <a href="{{ url('/promociones') }}" class="btn btn-sm btn-success">
            <i class="fas fa-chevron-left"></i>
             Regresar
          </a>
        </div>
      </div>
    </div>
    <div class="card-body">
      @if ($errors->any())
        <div class="alert alert-danger" role="alert">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ url('promociones/'.$promotion->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Imagen</label>
            <div class="card border-primary">
                <div class="card-body">
                    <label for="image" id="icon-image" class="btn btn-primary"><i class="fas fa-image"></i></label>
                    <span id="icon-cerrar"></span>
                    <input id="image" class="d-none" type="file" name="image" onchange="preview(event)"><br>
                    <input type="hidden" id="foto_actual" name="foto_actual">
                    @if($promotion->image)
                        <img class="img-thumbnail" id="img-preview" src="{{ asset($promotion->image) }}">
                    @else
                        <img class="img-thumbnail" id="img-preview" style="display: none;">
                    @endif
                </div>
            </div>
        </div>
        <div class="form-group">
          <label for="name">Nombre del paquete</label>
          <input type="text" name="name" class="form-control" value="{{ old('name', $promotion->name) }}">
        </div>
        <div class="form-group">
          <label for="description">Descripción</label>
          <textarea rows="4" name="description" class="form-control">{{ old('description', $promotion->description) }}</textarea>
        </div>
        <div class="form-group">
        <label for="price">Precio</label>
        <input type="text" name="price" class="form-control" value="{{ old('price', $promotion->price) }}">
        </div>
        <button type="submit" class="btn btn-primary">
          Guardar
        </button>
      </form>
    </div>
  </div>
@endsection
