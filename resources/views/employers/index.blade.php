@extends('layouts.panel')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col">
              <h3 class="mb-0">Empleados</h3>
            </div>
            <div class="col text-right">
              <a href="{{ url('/empleados/create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i> 
                 Nuevo empleado
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
          <!-- Projects table -->
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Correo</th>
                <th scope="col">Opciones</th>
              </tr>
            </thead>
            <tbody>
                @foreach($employers as $employer)
                    <tr>
                        <th scope="row">
                            {{ $employer->name }}
                        </th>
                        <td>
                            {{ $employer->email }}
                        </td>
                        <td>
                            <form id="delete-form-{{ $employer->id }}" action="{{ url('/empleados/'.$employer->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <a href="{{ url('/empleados/'.$employer->id.'/edit') }}" class="btn btn-sm btn-primary">
                                  <i class="fas fa-pencil-alt"></i>
                                   Editar
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" onclick="openConfirmPopup(this)" data-id="{{ $employer->id }}">
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
                        <h2>¿Está seguro que desea eliminar al empleado?</h2>
                        <button id="confirm-yes" class="btn btn-danger">Sí</button>
                        <button id="confirm-no" class="btn btn-secondary">No</button>
                    </div>
                </div>
            </tbody>
          </table>
        </div>
        <div class="card-body">
          {{ $employers->links() }}
        </div>
    </div>
@endsection