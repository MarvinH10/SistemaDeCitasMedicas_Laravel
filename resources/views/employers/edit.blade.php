<?php
    use Illuminate\Support\Str;
?>

@extends('layouts.panel')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0">Editar Empleado</h3>
                </div>
                <div>
                    <a href="{{ url('/empleados') }}" class="btn btn-sm btn-success">
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
            <form action="{{ url('/empleados/'.$employer->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nombre del empleado</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $employer->name) }}">
                </div>

                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="text" name="email" class="form-control" value="{{ old('email', $employer->email) }}">
                </div>

                <div class="form-group">
                    <label for="address">Dirección</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address', $employer->address) }}">
                </div>

                <div class="form-group">
                    <label for="phone">Teléfono / Móvil</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $employer->phone) }}">
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="text" name="password" class="form-control">
                    <small class="text-warning">Solo llena el campo si desea cambiar la contraseña</small>
                </div>
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="fas fa-save"></i>
                     Guardar cambios
                </button>
            </form>
        </div>
    </div>
@endsection