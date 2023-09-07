@extends('layouts.panel')

@section('content')
  <div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0">Promociones</h3>
        </div>
        <div class="col text-right">
          <a href="{{ url('promociones/create') }}" class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i>
             Nueva Promoción
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
       <table class="table align-items-center table-flush">
        <thead class="thead-light">
          <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Descripción</th>
            <th scope="col">Precio</th>
            <th scope="col">Opciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($promotions as $promotion)
          <tr>
            <th scope="row">
              {{ $promotion->name }}
            </th>
            <td>
              <ul>
                  @foreach(explode("\n", $promotion->description) as $point)
                      <li>{{ $point }}</li>
                  @endforeach
              </ul>
            </td>
            <td>
                {{ $promotion->price }}
              </td>
            <td>
              <form action="{{ url('/promociones/'.$promotion->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <a href="{{ url('/promociones/'.$promotion->id.'/edit') }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-pencil-alt"></i>
                   Editar
                </a>
                <button class="btn btn-sm btn-danger" type="submit">
                  <i class="fas fa-trash"></i>
                   Eliminar
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection