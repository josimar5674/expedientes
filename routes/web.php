<?php
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('expedientes.index')
        : redirect()->route('login');
});

Route::get('/dashboard', [ExpedienteController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::resource('expedientes', ExpedienteController::class);

});




Route::resource('expedientes', ExpedienteController::class)->middleware('auth');



Route::post('/expedientes/{expediente}/sujetos', 
    [ExpedienteController::class, 'storeSujeto']
)->name('expedientes.sujetos.store');


Route::post('/expedientes/{expediente}/movimientos', 
    [ExpedienteController::class, 'storeMovimiento']
)->name('expedientes.movimientos.store');

Route::post('/expedientes/{expediente}/documentos', 
    [ExpedienteController::class, 'storeDocumento']
)->name('expedientes.documentos.store');

Route::patch('/expedientes/{expediente}/estado', 
    [ExpedienteController::class, 'updateEstado']
)->name('expedientes.estado.update');

Route::put('/expedientes/{expediente}', [ExpedienteController::class, 'update'])
    ->name('expedientes.update');


    use App\Http\Controllers\UserController;

Route::middleware(['auth'])->group(function () {

    Route::resource('expedientes', ExpedienteController::class);

    Route::resource('usuarios', UserController::class)
        ->middleware('auth'); // luego lo afinamos a admin


        Route::resource('usuarios', UserController::class)
    ->middleware(['auth', 'admin']);
});
Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil');
require __DIR__.'/auth.php';
