@extends('layouts.panel')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col">
            <h3 class="mb-0">Publicaciones</h3>
            </div>
            <div class="col text-right">
            <a href="{{ url('blogs/create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i>
                Nueva Publicación
            </a>
            </div>
        </div>
        </div>
        <div class="card-body">
        @if(session('notification'))
            <div class="alert alert-success notification" role="alert">
                {{ session('notification') }}
            </div>
            <script>
                setTimeout(function() {
                    var notification = document.querySelector('.notification');
                    if (notification) {
                        notification.style.display = 'none';
                    }
                }, 3000);
            </script>
        @endif
        </div>
        <div class="table-responsive">
        <table class="table align-items-center table-flush">
            <thead class="thead-light">
            <tr>
                <th scope="col">Imagen | Video</th>
                <th scope="col">Título</th>
                <th scope="col">Descripción</th>
                <th scope="col">Tipo de Archivo</th>
                <th scope="col">Opciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($blogs as $blog)
            <tr>
                <td>
                    @if ($blog->tipo === 'imagen')
                        <img class="img-publication" src="{{ asset($blog->archivo) }}">
                    @elseif ($blog->tipo === 'video')
                        <video class="video-publication" controls width="200" height="150">
                            <source src="{{ asset($blog->archivo) }}" type="video/mp4">
                            Tu navegador no soporta la reproducción de videos.
                        </video>
                    @endif
                </td>
                <th class="title-cell" scope="row">
                    {{ $blog->titulo }}
                </th>
                <td class="description-cell">
                    {!! nl2br($blog->descripcion) !!}
                </td>
                <td>
                    {{ ucfirst($blog->tipo) }}
                </td>
                <td>
                <form id="delete-form-{{ $blog->id }}" action="{{ url('/blogs/'.$blog->id) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <a href="{{ url('/blogs/'.$blog->id.'/edit') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-pencil-alt"></i>
                        Editar
                    </a>
                    <button class="btn btn-sm btn-danger" type="button" onclick="openConfirmPopup(this)" data-id="{{ $blog->id }}">
                        <i class="fas fa-trash"></i>
                        Eliminar
                    </button>
                </form>
                </td>
            </tr>
            @endforeach
            <!-- Ventana emergente de confirmación -->
            <div id="confirm-popup" class="popup">
                <div class="popup-content">
                    <h2>¿Está seguro que desea eliminar la publicación?</h2>
                    <button id="confirm-yes" class="btn btn-danger">Sí</button>
                    <button id="confirm-no" class="btn btn-secondary">No</button>
                </div>
            </div>
            </tbody>
        </table>
        </div>
        <div class="card-body">
            {{ $blogs->links() }}
        </div>
    </div>
@endsection

