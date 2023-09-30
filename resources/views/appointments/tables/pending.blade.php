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
        @foreach ($pendingAppointments as $appointment)
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
            {{ $appointment->edad }}
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

            <form action="{{ url('/miscitas/'.$appointment->id.'/delete') }}"
              method="POST" class="d-inline-block mx-2">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-danger" type="submit"
                data-toggle="tooltip" title="Cancelar cita">
                <i class="fas fa-trash"></i>
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
