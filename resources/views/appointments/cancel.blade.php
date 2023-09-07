@extends('layouts.panel')

@section('content')
  <div class="card shadow">

    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0">Cancelar cita</h3>
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

      @if ($role == 'patient')
      <p>
        Estás a punto de cancelar tu cita reservada con el médico
        {{ $appointment->employer->name }}
        (promoción {{ $appointment->promotion->name }})
        para el día {{ $appointment->scheduled_date }}:
      </p>
      @elseif ($role == 'employer')
      <p>
        Estás a punto de cancelar tu cita con el paciente
        {{ $appointment->patient->name }}
        (promoción {{ $appointment->promotion->name }})
        para el día {{ $appointment->scheduled_date }}
        (hora {{ $appointment->scheduled_time_12 }}):
      </p>
      @else
      <p>
        Estás a punto de cancelar la cita reservada
        por el paciente {{ $appointment->patient->name }}
        para ser atendido por el médico {{ $appointment->employer->name }}
        (promoción {{ $appointment->promotion->name }})
        el día {{ $appointment->scheduled_date }}
        (hora {{ $appointment->scheduled_time_12 }}):
      </p>
      @endif

      <form action="{{ url('/miscitas/'.$appointment->id.'/cancel') }}" method="POST">
        @csrf

        <div class="form-group">
          <label for="justification">Por favor cuéntanos el motivo de la cancelación:</label>
          <textarea required id="justification" name="justification" rows="3" class="form-control"></textarea>
        </div>

        <button class="btn btn-danger" type="submit">Cancelar cita</button>
        <a href="{{ url('/miscitas') }}" class="btn btn-default">
          Volver al listado de citas sin cancelar
        </a>
      </form>
    </div>

  </div>
@endsection
