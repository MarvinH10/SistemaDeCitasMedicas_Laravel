@extends('layouts.panel')

@section('content')
<div class="row justify-content-center align-items-center">
  <div class="col-md-10 mb-1">
      <div class="card">
          <div class="card-header"><h1>Bienvenido <strong>{{ auth()->user()->name }}</strong>!</h1></div>
          <div class="card-body">
              @if (session('status'))
                  <div class="alert alert-success" role="alert">
                      {{ session('status') }}
                  </div>
              @endif
          </div>
      </div>
  </div>

  @if (auth()->user()->role == 'admin')
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats bg-yellow">
            <div class="card-header card-header-yellow card-header-icon">
                <div class="card-icon">
                    <i class="fas fa-cubes fa-2x ml-auto"></i>
                </div>
                <a class="text-white font-weight-bold">
                    Promociones
                </a>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between text-yellow font-weight-bold">
                <a href="/promociones" class="text-white font-weight-bold">Ver Detalle</a>
                <h3 class="card-title">{{ $totalPromotions }}</h3>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats bg-danger">
            <div class="card-header card-header-danger card-header-icon">
                <div class="card-icon">
                    <i class="fas fa-cubes fa-2x ml-auto"></i>
                </div>
                <a class="text-white font-weight-bold">
                    Blogs
                </a>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between text-danger font-weight-bold">
                <a href="/blogs" class="text-white font-weight-bold">Ver Detalle</a>
                <h3 class="card-title">{{ $totalBlogs }}</h3>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats bg-primary">
            <div class="card-header card-header-primary card-header-icon">
                <div class="card-icon">
                    <i class="fas fa-user fa-2x ml-auto"></i>
                </div>
                <a class="text-white font-weight-bold">
                    Empleados
                </a>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between text-primary font-weight-bold">
                <a href="/empleados" class="text-white font-weight-bold">Ver Detalle</a>
                <h3 class="card-title"> {{ $totalEmployers }} </h3>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats bg-success">
            <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                    <i class="fas fa-users fa-2x ml-auto"></i>
                </div>
                <a class="text-white font-weight-bold">
                    Pacientes
                </a>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between text-success font-weight-bold">
                <a href="/pacientes" class="text-white font-weight-bold">Ver Detalle</a>
                <h3 class="card-title">{{ $totalPatients }}</h3>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats bg-celeste">
            <div class="card-header card-header-celeste card-header-icon">
                <div class="card-icon">
                    <i class="fas fa-cubes fa-2x ml-auto"></i>
                </div>
                <a class="text-white font-weight-bold">
                    Citas Atendidas
                </a>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between text-celeste font-weight-bold">
                <a href="/miscitas" class="text-white font-weight-bold">Ver Detalle</a>
                <h3 class="card-title">{{ $totalCitas }}</h3>
            </div>
        </div>
    </div>
@endif
</div>
@endsection

@section('scripts')
    <script>
        const appointmentsByDay = @json($appointmentsByDay);
    </script>
    <script src="{{ asset('js/charts/home.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
@endsection
