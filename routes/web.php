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

Route::get('/about', [\App\Http\Controllers\LlamadoController::class, 'about']);
Route::get('/services', [\App\Http\Controllers\LlamadoController::class, 'services']);
Route::get('/packages', [\App\Http\Controllers\LlamadoController::class, 'packages']);
Route::get('/contacts', [\App\Http\Controllers\LlamadoController::class, 'contacts']);
Route::get('/blog-grid', [\App\Http\Controllers\BlogController::class, 'bloggrid'])->name('bloggrid');
Route::get('/detail-blog', [\App\Http\Controllers\BlogController::class, 'showLatest'])->name('latestBlog');
Route::get('detail-blog/{id}', [\App\Http\Controllers\BlogController::class, 'showdetails'])->name('blogdetail');
Route::post('add-comment/{id}', [\App\Http\Controllers\BlogController::class, 'addComment'])->name('addComment');
Route::get('/appointment', [\App\Http\Controllers\BlogController::class, 'appointment']);

// Ruta para mostrar el formulario de creación
Route::get('/testimonials/create', [\App\Http\Controllers\LlamadoController::class, 'create']);

// Ruta para almacenar un testimonio
Route::post('testimonials', [\App\Http\Controllers\LlamadoController::class, 'store'])->name('testimonials.store');

// Ruta para mostrar promociones y testimonios (puedes personalizarla según tu estructura)
Route::get('/', [\App\Http\Controllers\LlamadoController::class, 'index'])->name('blogs.testimonials.index');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'admin'])->group(function () {
    //Rutas Promociones
    Route::get('/promociones', [\App\Http\Controllers\admin\PromotionController::class, 'index']);
    Route::get('/promociones/create', [\App\Http\Controllers\admin\PromotionController::class, 'create']);
    Route::get('/promociones/{id}/edit', [\App\Http\Controllers\admin\PromotionController::class, 'edit']);
    Route::post('/promociones', [\App\Http\Controllers\admin\PromotionController::class, 'store']);
    Route::put('/promociones/{promotion}', [\App\Http\Controllers\admin\PromotionController::class, 'update']);
    Route::get('promociones/inactivate/{id}', [\App\Http\Controllers\admin\PromotionController::class, 'inactivate']);
    Route::get('promociones/reactivate/{id}', [\App\Http\Controllers\admin\PromotionController::class, 'reactivate']);
    // Route::delete('/promociones/{promotion}', [\App\Http\Controllers\admin\PromotionController::class, 'destroy']);

    //Rutas Blogs
    Route::get('/blogs', [\App\Http\Controllers\admin\BlogController::class, 'index']);
    Route::get('/blogs/create', [\App\Http\Controllers\admin\BlogController::class, 'create']);
    Route::get('/blogs/{id}/edit', [\App\Http\Controllers\admin\BlogController::class, 'edit']);
    Route::post('/blogs', [\App\Http\Controllers\admin\BlogController::class, 'store']);
    Route::put('/blogs/{blog}', [\App\Http\Controllers\admin\BlogController::class, 'update']);
    Route::delete('/blogs/{blog}', [\App\Http\Controllers\admin\BlogController::class, 'destroy']);

    //Rutas Empleados
    Route::resource('empleados', 'App\Http\Controllers\admin\EmployerController');

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
});

Route::middleware(['auth', 'admin_or_empleado'])->group(function () {
    //Rutas Pacientes
    Route::resource('pacientes', 'App\Http\Controllers\admin\PatientController');
});

Route::middleware('auth')->group(function(){
    //Ruta Reservar Citas
    Route::get('/reservarcitas/create', [\App\Http\Controllers\AppointmentController::class, 'create']);
    Route::post('/reservarcitas', [\App\Http\Controllers\AppointmentController::class, 'store']);

    //Ruta Mostrar Citas
    Route::get('/miscitas', [\App\Http\Controllers\AppointmentController::class, 'index'])->name('miscitas');
    Route::get('/miscitas/{appointment}', [\App\Http\Controllers\AppointmentController::class, 'show']);

    //Ruta Cancelar Citas
    Route::get('/miscitas/{appointment}/cancel', [\App\Http\Controllers\AppointmentController::class, 'showCancelForm']);
    Route::delete('/miscitas/{appointment}/delete', [\App\Http\Controllers\AppointmentController::class, 'deleteAppointment']);
	Route::post('/miscitas/{appointment}/cancel', [\App\Http\Controllers\AppointmentController::class, 'postCancel']);

    //Ruta Confirmar Citas
    Route::post('/miscitas/{appointment}/confirm', [\App\Http\Controllers\AppointmentController::class, 'postConfirm']);

    //Ruta Cita Atendida
    Route::put('/miscitas/{appointment}/mark-as-attended', [\App\Http\Controllers\AppointmentController::class, 'markAsAttended']);


    //Ruta Gestionar Horas
    Route::get('/horario/horas', [\App\Http\Controllers\Api\HorarioController::class, 'hours']);

    //Muestra de Opciones del User
    Route::get('/myperfil', [\App\Http\Controllers\PerfilController::class, 'index'])->name('perfil');
    Route::match(['put', 'patch'], '/myperfil/{id}', [\App\Http\Controllers\PerfilController::class, 'update'])->name('perfil.actualizar');
});
