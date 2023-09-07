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
        @foreach ($confirmedAppointments as $appointment)
        <tr>
          <th scope="row">
            {{ $appointment->promotion->name }}
          </th>
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
              <a class="btn btn-sm btn-primary" title="Ver cita"
                href="{{ url('/miscitas/'.$appointment->id) }}">
                  Ver
              </a>
            @endif
            <a class="btn btn-sm btn-danger" data-toggle="tooltip" title="Cancelar cita"
              href="{{ url('/miscitas/'.$appointment->id.'/cancel') }}">
              <i class="fas fa-ban"></i>
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="card-body">
    {{ $confirmedAppointments->links() }}
  </div>
