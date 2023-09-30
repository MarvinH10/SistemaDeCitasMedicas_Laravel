@extends('layouts.panel')
@section('styles')
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

    <!-- Css para Appointments solo -->
    <link rel="stylesheet" href="{{ asset('css/appointmentssolo.css') }}">
    <!-- Replace the "test" client-id value with your client-id -->
    <script src="https://www.paypal.com/sdk/js?client-id=Ab29P_svT8ZR40zR6L7Ph0Myl8rZMRc689TDZRo94iyT05sBCUGGu6vx9w7Tcj1KFboJm7i9-wsMdC0q&currency=USD"></script>
@endsection

@section('content')
  <div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0">Rellena el formulario para una nueva cita</h3>
        </div>
        <div>
            <a href="{{ url('/home') }}" class="btn btn-sm btn-success">
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
                    <strong>Por favor, rellene todos los campos!!</strong>
                </div>
            @endforeach
        @endif


      <form action="{{ url('/reservarcitas') }}" method="POST">
        @csrf
        <div class="form-group">
          <label for="date">Fecha</label>
          <div class="input-group input-group-alternative">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
              </div>
            <input class="form-control datepicker" placeholder="Seleccionar fecha"
              id="date" name="scheduled_date" type="text"
              value="{{ old('scheduled_date', date('Y-m-d')) }}"
              data-date-format="yyyy-mm-dd"
              data-date-start-date="{{ date('Y-m-d') }}"
              data-date-end-date="+30d">
          </div>
        </div>

        <div class="form-group">
            <div id="hours">
                @if ($intervals)
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="small-text">Hora de atención en la Mañana</h3>
                        <div id="morning-intervals" class="form-group">
                            @php
                                $morningIntervalsAvailable = false;
                            @endphp
                            @foreach ($intervals['morning'] as $key => $interval)
                                @php
                                    $isExcluded = in_array($interval['start'], ['1:30 PM', '2:00 PM', '2:30 PM']);
                                    $currentTime = date('g:i A');
                                @endphp
                                @if (!$isExcluded && strtotime($interval['start']) > strtotime($currentTime))
                                    <div class="custom-control custom-radio mb-3">
                                        <input name="scheduled_time" value="{{ $interval['start'] }}" class="custom-control-input" id="intervalMorning{{ $key }}" type="radio" required>
                                        <label class="custom-control-label" for="intervalMorning{{ $key }}">{{ $interval['start'] }} - {{ $interval['end'] }}</label>
                                    </div>
                                    @php
                                        $morningIntervalsAvailable = true;
                                    @endphp
                                @endif
                            @endforeach
                            @if (!$morningIntervalsAvailable)
                                <div class="alert" role="alert">
                                    <strong>No hay citas disponibles en la mañana.</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3 class="small-text">Hora de atención en la Tarde</h3>
                        <div id="afternoon-intervals" class="form-group">
                            @php
                                $afternoonIntervalsAvailable = false;
                            @endphp
                            @foreach ($intervals['afternoon'] as $key => $interval)
                                @php
                                    $isExcluded = in_array($interval['start'], ['1:30 PM', '2:00 PM', '2:30 PM']);
                                    $currentTime = date('g:i A');
                                @endphp
                                @if (!$isExcluded && strtotime($interval['start']) > strtotime($currentTime))
                                    <div class="custom-control custom-radio mb-3">
                                        <input name="scheduled_time" value="{{ $interval['start'] }}" class="custom-control-input" id="intervalAfternoon{{ $key }}" type="radio" required>
                                        <label class="custom-control-label" for="intervalAfternoon{{ $key }}">{{ $interval['start'] }} - {{ $interval['end'] }}</label>
                                    </div>
                                    @php
                                        $afternoonIntervalsAvailable = true;
                                    @endphp
                                @endif
                            @endforeach
                            @if (!$afternoonIntervalsAvailable)
                                <div class="alert" role="alert">
                                    <strong>No hay citas disponibles en la tarde.</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @else
                    <div class="alert alert-light" role="alert">
                        No hay fechas de citas disponibles
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group">
            <h3 class="small-text">Promoción</h3>
            @if(count($activePromotions) > 0)
                <select name="promotion_id" id="promotions" class="form-control selectpicker"
                        data-style="btn-primary" title="Selecciona una promoción" required>
                    @foreach($activePromotions as $promotion)
                        <option value="{{ $promotion->id }}"
                                data-description="{{ $promotion->description }}"
                                data-price="{{ $promotion->price }}">
                            {{ $promotion->name }}
                        </option>
                    @endforeach
                </select>
            @else
                <div class="alert" role="alert">
                    <strong>No hay promociones disponibles en este momento.</strong>
                </div>
            @endif
        </div>

        <div id="promotion-details" style="display: none;">
            <h2>Detalles de la Promoción</h2>
            <p><strong>Descripciones:</strong></p>
            <ul id="promotion-description">
            </ul>
            <p><strong>Precio:</strong> <span id="promotion-price"></span></p>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-4 mb-2">
                    <label for="name">Nombres y Apellidos</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Ingresa tu nombre y apellido" required>
                </div>
                <div class="col-md-4 mb-2">
                    <label for="dni">N° de DNI</label>
                    <input type="number" name="dni" id="dni" class="form-control" placeholder="Ingresa tu N° de DNI" required>
                </div>
                <div class="col-md-4 mb-2">
                    <label for="edad">¿Eres mayor de edad?</label>
                    <select name="edad" id="edad" data-style="btn-primary" class="form-control selectpicker">
                        <option value="si">Sí</option>
                        <option value="no">No</option>
                    </select>
                </div>
                <div id="mensajeAcompanante" class="toast warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    Debes ir acompañado de alguien mayor o un adulto.
                </div>
                <div class="col-md-4 mb-2">
                    <label for="phone">Teléfono/Celular</label>
                    <input type="number" name="phone" id="phone" class="form-control" placeholder="Ingresa tu número de celular" required>
                </div>
            </div>
        </div>
        <button style="margin-top:5px" type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i>
            Reservar
        </button>
      </form>
    </div>
  </div>
@endsection

@section('scripts')
  <!-- First compiled and minified JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  {{-- Second --}}
  <script src="{{ asset('js/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

  {{-- Third --}}
  <script>
    // Mostrar la ventana flotante
    function mostrarMensaje() {
        var mensaje = document.getElementById('mensajeAcompanante');
        mensaje.style.display = 'block';

        // Ocultar la ventana flotante después de 3 segundos (3000 milisegundos)
        setTimeout(function() {
            mensaje.style.display = 'none';
        }, 5000);
    }

    // Ejemplo: mostrar la ventana flotante cuando el usuario selecciona "No"
    document.getElementById('edad').addEventListener('change', function() {
        if (this.value === 'no') {
            mostrarMensaje();
        }
    });
  </script>
  <script>
    // Script para mostrar las descripciones de la promoción seleccionada
    $('#promotions').on('change', function() {
        // Obtener la descripción y el precio de la promoción seleccionada
        const selectedOption = $(this).find('option:selected');
        const description = selectedOption.data('description');
        const price = selectedOption.data('price');

        // Mostrar la descripción en la lista de puntos
        const descriptionList = $('#promotion-description');
        descriptionList.empty();
        const points = description.split('\n');
        points.forEach(point => {
            descriptionList.append(`<li>${point.trim()}</li>`);
        });

        // Mostrar el precio
        $('#promotion-price').text(price);

        // Mostrar el elemento de detalles de la promoción
        $('#promotion-details').show();
    });
</script>
@endsection
