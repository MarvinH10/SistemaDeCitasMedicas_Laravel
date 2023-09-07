@extends('layouts.panel')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col">
              <h3 class="mb-0">Pacientes</h3>
            </div>
            <div class="col text-right">
              <a href="{{ url('/pacientes/create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i>
                 Nuevo paciente
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
                @foreach($patients as $patient)
                    <tr>
                        <th scope="row">
                            {{ $patient->name }}
                        </th>
                        <td>
                            {{ $patient->email }}
                        </td>
                        <td>
                            <form id="delete-form-{{ $patient->id }}" action="{{ url('/pacientes/'.$patient->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <a href="{{ url('/pacientes/'.$patient->id.'/edit') }}" class="btn btn-sm btn-primary">
                                  <i class="fas fa-pencil-alt"></i>
                                   Editar
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" onclick="openConfirmPopup(this)" data-id="{{ $patient->id }}">
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
          {{ $patients->links() }}
        </div>
    </div>
@endsection
