@extends('layouts.panel')
@section('styles')
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endsection

@section('content')
  <div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0">Formulario para una nueva cita</h3>
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
                    <strong>Por favor!!</strong> {{ $error }}
                </div>
            @endforeach
        @endif

      <form action="{{ url('/miscitas') }}" method="POST">
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
                        <h3>Hora de atención en la Mañana</h3>
                        <div class="form-group">
                            @foreach ($intervals['morning'] as $key => $interval)
                                @php
                                    // Verificar si el intervalo es 2:00 PM - 2:30 PM o 2:30 PM - 3:00 PM
                                    $isExcluded = in_array($interval['start'], ['1:30 PM', '2:00 PM', '2:30 PM']);
                                @endphp
                                @if (!$isExcluded)
                                    <div class="custom-control custom-radio mb-3">
                                        <input name="scheduled_time" value="{{ $interval['start'] }}" class="custom-control-input" id="intervalMorning{{ $key }}" type="radio" required>
                                        <label class="custom-control-label" for="intervalMorning{{ $key }}">{{ $interval['start'] }} - {{ $interval['end'] }}</label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3>Hora de atención en la Tarde</h3>
                        <div class="form-group">
                            @foreach ($intervals['afternoon'] as $key => $interval)
                                @php
                                    // Verificar si el intervalo es 2:00 PM - 2:30 PM o 2:30 PM - 3:00 PM
                                    $isExcluded = in_array($interval['start'], ['1:30 PM', '2:00 PM', '2:30 PM']);
                                @endphp
                                @if (!$isExcluded)
                                    <div class="custom-control custom-radio mb-3">
                                        <input name="scheduled_time" value="{{ $interval['start'] }}" class="custom-control-input" id="intervalAfternoon{{ $key }}" type="radio" required>
                                        <label class="custom-control-label" for="intervalAfternoon{{ $key }}">{{ $interval['start'] }} - {{ $interval['end'] }}</label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                @else
                    <div class="alert alert-info" role="alert">
                        No hay fechas de citas disponibles.
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group">
            <label for="promotion_id">Promoción</label>
            <select name="promotion_id" id="promotions" class="form-control selectpicker"
                    data-style="btn-primary" title="Selecciona una promoción">
                @foreach($promotions as $promotion)
                    <option value="{{ $promotion->id }}">{{ $promotion->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-4 mb-2">
                    <label for="name">Nombres y Apellidos</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Ingresa tu nombre y apellido">
                </div>
                <div class="col-md-4 mb-2">
                    <label for="dni">N° de DNI</label>
                    <input type="number" name="dni" id="dni" class="form-control" placeholder="Ingresa tu N° de DNI">
                </div>
                <div class="col-md-4 mb-2">
                    <label for="edad">Edad</label>
                    <input type="number" name="edad" id="edad" class="form-control" placeholder="Ingresa tu edad">
                </div>
                <div class="col-md-4 mb-2">
                    <label for="genero">Género</label>
                    <select name="genero" id="genero" class="form-control">
                        <option value="masculino">Masculino</option>
                        <option value="femenino">Femenino</option>
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <label for="religion">Religión</label>
                    <input type="text" name="religion" id="religion" class="form-control" placeholder="Ingresa tu religión">
                </div>
                <div class="col-md-4 mb-2">
                    <label for="grade">Grados de instrucción</label>
                    <input type="text" name="grade" id="grade" class="form-control" placeholder="Ingresa tu grado de instrucción">
                </div>
                <div class="col-md-4 mb-2">
                    <label for="civil_status">Estado civil</label>
                    <select name="civil_status" id="civil_status" class="form-control">
                        <option value="soltero">Soltero(a)</option>
                        <option value="casado">Casado(a)</option>
                        <option value="divorciado">Divorciado(a)</option>
                        <option value="viudo">Viudo(a)</option>
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <label for="site_born">Lugar de nacimiento</label>
                    <input type="text" name="site_born" id="site_born" class="form-control" placeholder="Ingresa el lugar de tu nacimiento">
                </div>
                <div class="col-md-4 mb-2">
                    <label for="born_date">Fecha de Nacimiento</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar-plus"></i></span>
                        </div>
                        <input class="form-control datepicker" placeholder="Selecciona tu fecha de nacimiento (Año-Mes-Día)"
                            id="born_date" name="born_date" type="text"
                            value="{{ old('born_date') }}"
                            data-date-format="yyyy-mm-dd"
                            data-date-start-date="1900-01-01"
                            data-date-end-date="{{ date('Y-m-d') }}">
                    </div>
                </div>
                <div class="col-md-4 mb-2">
                    <label for="home">Domicilio</label>
                    <input type="text" name="home" id="home" class="form-control" placeholder="Ingresa tu domicilio">
                </div>
                <div class="col-md-4 mb-2">
                    <label for="occupation">Ocupación</label>
                    <input type="text" name="occupation" id="occupation" class="form-control" placeholder="Ingresa tu ocupación">
                </div>
                <div class="col-md-4 mb-2">
                    <label for="phone">Teléfono/Celular</label>
                    <input type="number" name="phone" id="phone" class="form-control" placeholder="Ingresa tu número de celular">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i>
            Reservar
        </button>
      </form>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
@endsection
