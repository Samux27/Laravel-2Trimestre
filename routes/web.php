<?php
use App\Http\Controllers\TareasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\OperarioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\CuotasController;
use App\Http\Controllers\SocialiteController;
use Illuminate\Support\Facades\Route;

Route::controller(SocialiteController::class)->group(function(){
    Route::get('auth/google-callback', 'googleAuthentication')->name('auth.google-callback');
    Route::get('auth/google', 'googlelogin')->name('auth.google'); // Corrección aquí
});



Route::view('/','welcome');
route::resource('tareas',TareasController::class);
Route::get('/mis-tareas', [OperarioController::class, 'misTareas'])
    ->name('operario.misTareas')
    ->middleware('auth');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Ruta específica para mostrar detalles de una tarea en 'mostrarTarea'
Route::resource('guest',GuestController::class);
Route::post('/verificar', [GuestController::class, 'verificar'])->name('verificar.datos');
Route::view('/verificar/create','guest.create')->name('verificar.create');



require __DIR__.'/auth.php';
Route::view('7Incidencias','guest.añadirIncidencia')->name("guest.registrarIncidencia");
Route::resource('clientes', ClienteController::class);
Route::resource('cuotas',CuotasController::class);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('operario', OperarioController::class);
    Route::get('/completar/{id}', [OperarioController::class, 'completar'])->name('operario.completar');
    Route::get('/listarTareas', [TareasController::class, 'index'])->name('tareas.listar');
    Route::get('/listarUsuarios', [UsuarioController::class, 'index'])->name('usuarios.listar');
    Route::get('/tareas/{id}', [TareasController::class, 'show'])->name('tareas.mostrar');
    Route::view('/tareas/{id}/edit', 'editarTarea')->name('tarea.edit');
    Route::view('/insertarTarea', 'insertarTarea')->name('insertarTarea');
    Route::view('/insertarTarea','insertarTarea')->name('tarea.create');
    Route::view('/insertarTarea','insertarTarea')->name('usuario.create');
    Route::view('/insertarTarea', 'insertarTarea')->name('insertarTarea');
    Route::view('/Incidencias', 'guest.añadirIncidencia')->name('guest.registrarIncidencia');