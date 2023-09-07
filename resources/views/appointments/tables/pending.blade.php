<div class="table-responsive">
    <table class="table align-items-center table-flush">
      <thead class="thead-light">
        <tr>
          <th scope="col">Promoción</th>
          @if ($role == 'empleado')
            <th scope="col">Paciente</th>
          @endif
          <th scope="col">Fecha</th>
          <th scope="col">Hora</th>
          <th scope="col">Género</th>
          <th scope="col">Opciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($pendingAppointments as $appointment)
        <tr>
          <td>
            {{ $appointment->promotion->name }}
          </td>
          @if ($role == 'empleado')
            <td>{{ $appointment->patient->name }}</td>
          @endif
          <td>
            {{ $appointment->scheduled_date }}
          </td>
          <td>
            {{ $appointment->scheduled_time_12 }}
          </td>
          <td>
            {{ $appointment->genero }}
          </td>
          <td>
            @if ($role == 'admin')
              <a class="btn btn-sm btn-primary" data-toggle="tooltip" title="Ver cita"
                href="{{ url('/miscitas/'.$appointment->id) }}">
                <i class="fas fa-eye"></i>
              </a>
            @endif

            @if ($role == 'empleado' || $role == 'admin')
              <form action="{{ url('/miscitas/'.$appointment->id.'/confirm') }}"
                method="POST" class="d-inline-block">
                @csrf
                <button class="btn btn-sm btn-success" type="submit"
                  data-toggle="tooltip" title="Confirmar cita">
                  <i class="fas fa-check"></i>
                </button>
              </form>
            @endif

            <form action="{{ url('/miscitas/'.$appointment->id.'/cancel') }}"
              method="POST" class="d-inline-block mx-2">
              @csrf
              <button class="btn btn-sm btn-danger" type="submit"
                data-toggle="tooltip" title="Cancelar cita">
                <i class="fas fa-ban"></i>
              </button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="card-body">
    {{ $pendingAppointments->links() }}
  </div>
