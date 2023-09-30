<div class="table-responsive">
    <table class="table align-items-center table-flush">
      <thead class="thead-light">
        <tr>
          <th scope="col">Promoción</th>
          <th scope="col">Precio</th>
          <th scope="col">Fecha</th>
          <th scope="col">Hora</th>
          <th scope="col">Nombre Completo</th>
          <th scope="col">Teléfono|Celular</th>
          <th scope="col">¿Mayor de edad?</th>
          <th scope="col">Opciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($confirmedAppointments as $appointment)
        <tr>
          <th scope="row">
            {{ $appointment->promotion->name }}
          </th>
          <td>
            S/. {{ $appointment->promotion->price }}
          </td>
          <td>
            {{ $appointment->scheduled_date }}
          </td>
          <td>
            {{ $appointment->scheduled_time_12 }}
          </td>
          <td>
            {{ $appointment->name }}
          </td>
          <td>
            {{ $appointment->phone }}
          </td>
          <td>
            {{ ucfirst($appointment->edad) }}
          </td>
          <td>
            <form method="POST" action="{{ url('/miscitas/'.$appointment->id.'/mark-as-attended') }}" style="display: inline;">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-sm btn-success" data-toggle="tooltip" title="Marcar como atendida">
                    <i class="fas fa-check"></i>
                </button>
            </form>
            @if ($role == 'admin')
                <a href="{{ url('/miscitas/'.$appointment->id) }}" class="btn btn-primary btn-sm"
                    data-toggle="tooltip" title="Ver la cita confirmada">
                    <i class="fas fa-eye"></i>
                </a>
            @endif
            <a class="btn btn-sm btn-danger" data-toggle="tooltip" title="Cancelar la cita confirmada"
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
