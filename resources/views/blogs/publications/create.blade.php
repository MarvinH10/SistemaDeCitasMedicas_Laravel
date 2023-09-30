@extends('layouts.panel')

@section('content')
  <div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0">Nueva publicación</h3>
        </div>
        <div class="col text-right">
          <a href="{{ url('/blogs') }}" class="btn btn-sm btn-success">
            <i class="fas fa-chevron-left"></i>
             Regresar
          </a>
        </div>
      </div>
    </div>
    <div class="card-body">
      @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Por favor!!</strong> {{ $error }}
            </div>
        @endforeach
      @endif

      <form action="{{ url('blogs') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Archivo</label>
            <div class="card border-primary">
                <div class="card-body">
                    <div class="mb-2">
                        <button type="button" id="image-btn" class="btn btn-primary"><i class="fas fa-image"></i> Subir Imagen</button>
                        <button type="button" id="video-btn" class="btn btn-dark"><i class="fas fa-video"></i> Subir Video</button>
                    </div>
                    <span id="icon-cerrar">
                        <button id="delete-button" class="btn btn-danger" style="display: none;" type="button" onclick="deleteFile()"><i class="fas fa-times"></i> Eliminar</button>
                    </span>
                    <input id="file-input" class="d-none" type="file" name="archivo">
                    <input type="hidden" id="archivo_actual" name="archivo_actual">
                    <img class="img-thumbnail" id="img-preview" style="display: none;">
                    <video id="video-preview" controls style="display: none;"></video>
                </div>
            </div>
        </div>
        <div class="form-group">
          <label for="title">Título de publicación</label>
          <input type="text" name="title" class="form-control" value="{{ old('title') }}">
        </div>
        <div class="form-group">
          <label for="description">Descripción</label>
          <textarea rows="4" name="description" class="form-control" value="{{ old('description') }}"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">
          Guardar
        </button>
      </form>
    </div>
  </div>
  <script>
    //Subir Blogs
    const imageBtn = document.getElementById('image-btn');
    const videoBtn = document.getElementById('video-btn');
    const fileInput = document.getElementById('file-input');
    const imgPreview = document.getElementById('img-preview');
    const videoPreview = document.getElementById('video-preview');
    const deleteButton = document.getElementById('delete-button');

    imageBtn.addEventListener('click', function () {
        fileInput.accept = 'image/*';
        fileInput.click();
    });

    videoBtn.addEventListener('click', function () {
        fileInput.accept = 'video/*';
        fileInput.click();
    });

    fileInput.addEventListener('change', function (event) {
        const selectedFile = event.target.files[0];

        if (selectedFile) {
            const fileType = selectedFile.type;
            const validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
            const validVideoTypes = ['video/mp4', 'video/webm', 'video/quicktime'];
            document.getElementById("icon-cerrar").innerHTML = `
            <button class="btn btn-danger" onclick="deleteFile()"><i class="fas fa-times"></i></button>
            ${selectedFile.name}<br><br>`;

            if (validImageTypes.includes(fileType)) {
                const urlTmp = URL.createObjectURL(selectedFile);
                imgPreview.src = urlTmp;
                videoPreview.style.display = 'none';
                imgPreview.style.display = 'block';
                document.getElementById("icon-image").classList.add("d-none");
            } else if (validVideoTypes.includes(fileType)) {
                const urlTmp = URL.createObjectURL(selectedFile);
                videoPreview.src = urlTmp;
                imgPreview.style.display = 'none';
                videoPreview.style.display = 'block';
                document.getElementById("icon-image").classList.add("d-none");
            } else {
                Swal.fire({
                    icon: 'error',
                    text: 'Por favor, seleccione un archivo de imagen o video válido.'
                });

                fileInput.value = null;
            }
        }
    });
  </script>
@endsection
