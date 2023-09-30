@extends('layouts.panel')

@section('content')
{{-- CSS --}}
<link href="{{ asset('css/perfil.css') }}" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
<link href="{{ asset('css/perfilboots.css') }}" rel="stylesheet" />
<div class="card shadow">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col">
            <h3 class="mb-0">Mi Perfil</h3>
            </div>
        </div>
    </div>
    <div class="card-body d-flex flex-column align-items-center">
        {{-- Imagen del perfil del usuario --}}
        <div class="form-group">
            <img class="perfil" src="{{ asset(Auth::user()->image) }}">
            <div class="form-group">
                <button type="button" class="boton-perfil" data-bs-toggle="modal" data-bs-target="#newPerfil{{ Auth::user()->id }}">
                    <i class="fa-solid fa-arrows-rotate"></i> Actualizar mis datos
                </button>
            </div>
        </div>
        <div class="col-md-9 custom-centered">
            <div class="card-body-dark rounded">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="listar-datos m-2">
                                <li class="m-3"><i class="fas fa-user"></i> <strong>Nombres:</strong><br>* {{ Auth::user()->name }}</li>
                                <li class="m-3"><i class="fa-solid fa-envelope"></i> <strong>Correo electrónico:</strong><br>* {{ Auth::user()->email }}</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="listar-datos m-2">
                                <li class="m-3"><i class="fas fa-phone-alt"></i> <strong>Teléfono|Celular:</strong><br>* {{ Auth::user()->phone }}</li>
                                <li class="m-3"><i class="fas fa-map-signs"></i> <strong>Dirección:</strong><br>* {{ Auth::user()->address }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modales para datos de perfil -->
<div class="modal fade" id="newPerfil{{ Auth::user()->id }}" tabindex="-1" aria-labelledby="newPerfilLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            @if($errors->any())
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Por favor!!</strong> {{ $error }}
                    </div>
                @endforeach
            @endif
            <form method="POST" action="{{ route('perfil.actualizar', ['id' => Auth::user()->id]) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="newPortadaLabel">
                        Actualizar mi Perfil
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <strong>Selecciona una nueva foto de perfil:</strong>
                        <input type="file" name="perfil_image" class="form-control" accept="image/*" id="perfil_image">
                    </div>
                    <div class="mb-3">
                        <strong>Nombres:</strong>
                        <input type="text" name="name" class="form-control" value="{{ old('name', Auth::user()->name) }}">
                    </div>
                    <div class="mb-3">
                        <strong>Correo Electrónico:</strong>
                        <input type="email" name="email" class="form-control" value="{{ old('name', Auth::user()->email) }}">
                    </div>
                    <div class="mb-3">
                        <strong>Teléfono|Celular:</strong>
                        <input type="text" name="phone" class="form-control" value="{{ old('name', Auth::user()->phone) }}">
                    </div>
                    <div class="mb-3">
                        <strong>Dirección:</strong>
                        <input type="text" name="address" class="form-control" value="{{ old('name', Auth::user()->address) }}">
                    </div>
                    <div class="mb-3">
                        <strong>Contraseña</strong>
                        <input type="text" name="password" class="form-control">
                        <small class="text-warning">Solo llena el campo si desea cambiar la contraseña</small>
                    </div>
                    <div class="mb-3">
                        <strong>Vista previa:</strong>
                        <div id="image-preview">
                            <img class="img-fluid" src="{{ asset(Auth::user()->image) }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- JS de Bootstrap (asegúrate de que jQuery y Popper.js estén cargados antes de Bootstrap) -->
<script>
    document.getElementById('perfil_image').addEventListener('change', function() {
        var fileInput = this;
        var imagePreview = document.getElementById('image-preview');

        while (imagePreview.firstChild) {
            imagePreview.removeChild(imagePreview.firstChild);
        }

        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                var img = document.createElement('img');
                img.src = e.target.result;
                img.style.maxWidth = '100%';
                img.style.height = 'auto';
                imagePreview.appendChild(img);

                // Remove the previous image from the preview
                var previousImage = document.querySelector('.img-fluid');
                if (previousImage) {
                    previousImage.parentNode.removeChild(previousImage);
                }
            };

            reader.readAsDataURL(fileInput.files[0]);
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
@endsection
