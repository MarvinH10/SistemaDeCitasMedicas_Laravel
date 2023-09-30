@extends('layouts.panel')

@section('content')
<form action="{{ url('/horario') }}" method="POST">
  @csrf
    <div class="card shadow">
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col">
              <h3 class="mb-0">Gestionar Horario</h3>
            </div>
            <div class="col text-right">
              <button type="submit" class="btn btn-sm btn-success">
                <i class="fas fa-save"></i>
                 Guardar cambios
              </button>
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

            @if (session('errors'))
              <div class="alert alert-danger" role="alert">
                Los cambios se han guardado, pero se encontraron las siguientes novedades:
                <ul>
                  @foreach (session('errors') as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
        </div>
        <div class="table-responsive">
          <!-- Projects table -->
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th scope="col">Día</th>
                <th scope="col">Activo</th>
                <th scope="col">Turno mañana</th>
                <th scope="col">Turno tarde</th>
              </tr>
            </thead>
            <tbody>
                @foreach($horarios as $key => $horario)
                    <tr>
                        <th>{{ $days[$key] }}</th>
                        <td>
                          <label class="custom-toggle">
                              <input type="checkbox" name="active[]" value="{{ $key }}"
                              @if($horario->active) checked @endif>
                              <span class="custom-toggle-slider rounded-circle"></span>
                          </label>
                        </td>

                        <td>
                          <div class="row">
                            <div class="col">
                              <select class="form-control" name="morning_start[]">
                                @for($i=8; $i<=11; $i++)
                                  <option value="{{ ($i<10 ? '0' : '') . $i }}:00"
                                  @if($i.':00 AM' == $horario->morning_start) selected @endif>
                                    {{ $i }}:00 AM
                                  </option>
                                  <option value="{{ ($i<10 ? '0' : '') . $i }}:30"
                                  @if($i.':30 AM' == $horario->morning_start) selected @endif>
                                    {{ $i }}:30 AM
                                  </option>
                                @endfor
                                <option value="11:30"
                                    @if('11:30 AM' == $horario->morning_start) selected @endif>
                                    11:30 AM
                                </option>
                                <option value="11:59"
                                    @if('11:59 AM' == $horario->morning_start) selected @endif>
                                    11:59 AM
                                </option>
                              </select>
                            </div>

                            <div class="col">
                              <select class="form-control" name="morning_end[]">
                                @for($i=8; $i<12; $i++)
                                  <option value="{{ ($i<10 ? '0' : '') . $i }}:00"
                                  @if($i.':00 AM' == $horario->morning_end) selected @endif>
                                    {{ $i }}:00 AM
                                  </option>
                                  <option value="{{ ($i<10 ? '0' : '') . $i }}:30"
                                  @if($i.':30 AM' == $horario->morning_end) selected @endif>
                                    {{ $i }}:30 AM
                                  </option>
                                @endfor
                                <option value="11:30"
                                    @if('11:30 AM' == $horario->morning_end) selected @endif>
                                    11:30 AM
                                </option>
                                <option value="11:59"
                                    @if('11:59 AM' == $horario->morning_end) selected @endif>
                                    11:59 AM
                                </option>
                              </select>
                            </div>
                          </div>
                        </td>

                        <td>
                            <div class="row">
                                <div class="col">
                                    <select class="form-control" name="afternoon_start[]">
                                        @for($i = 0; $i <= 8; $i++)
                                            @php
                                                $formattedHour = ($i == 0) ? '12' : $i;
                                                $formattedTime = $formattedHour . ':00 PM';
                                            @endphp
                                            @if (!in_array($formattedHour, [2, 3]))
                                                <option value="{{ $i + 12 }}:00"
                                                    @if($formattedTime == $horario->afternoon_start) selected @endif>
                                                    {{ $formattedTime }}
                                                </option>
                                            @endif
                                            @if ($i != 8)
                                                @if (!in_array($formattedHour, [1, 2]))
                                                    <option value="{{ $i + 12 }}:30"
                                                        @if($formattedHour.':30 PM' == $horario->afternoon_start) selected @endif>
                                                        {{ $formattedHour }}:30 PM
                                                    </option>
                                                @endif
                                            @endif
                                        @endfor
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="form-control" name="afternoon_end[]">
                                        @for($i = 0; $i <= 8; $i++)
                                            @php
                                                $formattedHour = ($i == 0) ? '12' : $i;
                                                $formattedTime = $formattedHour . ':00 PM';
                                            @endphp
                                            @if (!in_array($formattedHour, [2, 3]))
                                                <option value="{{ $i + 12 }}:00"
                                                    @if($formattedTime == $horario->afternoon_end) selected @endif>
                                                    {{ $formattedTime }}
                                                </option>
                                            @endif
                                            @if ($i != 8)
                                                @if (!in_array($formattedHour, [1, 2]))
                                                    <option value="{{ $i + 12 }}:30"
                                                        @if($formattedHour.':30 PM' == $horario->afternoon_end) selected @endif>
                                                        {{ $formattedHour }}:30 PM
                                                    </option>
                                                @endif
                                            @endif
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
          </table>
        </div>
    </div>
</form>
@endsection
