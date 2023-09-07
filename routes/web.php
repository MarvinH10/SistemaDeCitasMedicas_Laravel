<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'admin'])->group(function () {
    //Rutas Promociones
    Route::get('/promociones', [\App\Http\Controllers\admin\PromotionController::class, 'index']);
    Route::get('/promociones/create', [\App\Http\Controllers\admin\PromotionController::class, 'create']);
    Route::get('/promociones/{id}/edit', [\App\Http\Controllers\admin\PromotionController::class, 'edit']);
    Route::post('/promociones', [\App\Http\Controllers\admin\PromotionController::class, 'store']);
    Route::put('/promociones/{promotion}', [\App\Http\Controllers\admin\PromotionController::class, 'update']);
    Route::delete('/promociones/{promotion}', [\App\Http\Controllers\admin\PromotionController::class, 'destroy']);

    //Rutas Empleados
    Route::resource('empleados', 'App\Http\Controllers\admin\EmployerController');

    //Rutas Pacientes
    Route::resource('mispacientes', 'App\Http\Controllers\admin\PatientController');

    // Charts
    Route::get('/chart', [\App\Http\Controllers\admin\ChartController::class, 'index']);
	Route::get('/charts/appointments/line', [\App\Http\Controllers\admin\ChartController::class, 'appointments']);
	Route::get('/charts/employers/column', [\App\Http\Controllers\admin\ChartController::class, 'employers']);
	Route::get('/charts/employers/column/data', [\App\Http\Controllers\admin\ChartController::class, 'employersJson']);

    // FCM
	Route::post('/fcm/send', [\App\Http\Controllers\admin\FirebaseController::class, 'sendAll']);
});

Route::middleware(['auth', 'empleado'])->group(function () {
    Route::get('/horario', [\App\Http\Controllers\employer\HorarioController::class, 'edit']);
    Route::post('/horario', [\App\Http\Controllers\employer\HorarioController::class, 'store']);

    //Rutas Pacientes
    Route::resource('pacientes', 'App\Http\Controllers\admin\PatientController');
});

Route::middleware('auth')->group(function(){
    Route::get('/reservarcitas/create', [\App\Http\Controllers\AppointmentController::class, 'create']);
    Route::post('/miscitas', [\App\Http\Controllers\AppointmentController::class, 'store']);

    Route::get('/miscitas', [\App\Http\Controllers\AppointmentController::class, 'index']);
    Route::get('/miscitas/{appointment}', [\App\Http\Controllers\AppointmentController::class, 'show']);

    Route::get('/miscitas/{appointment}/cancel', [\App\Http\Controllers\AppointmentController::class, 'showCancelForm']);
	Route::post('/miscitas/{appointment}/cancel', [\App\Http\Controllers\AppointmentController::class, 'postCancel']);

    Route::post('/miscitas/{appointment}/confirm', [\App\Http\Controllers\AppointmentController::class, 'postConfirm']);

    //JSON
    Route::get('/horario/horas', [\App\Http\Controllers\Api\HorarioController::class, 'hours']);
});
