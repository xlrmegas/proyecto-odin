<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

// Tu link final será: http://TU-IP/api/v1/recepcion
Route::post('/v1/recepcion', function (Request $request) {
    // Esto guarda TODO lo que envíe tu software en storage/logs/laravel.log
    Log::info('Datos recibidos del software:', $request->all());

    return response()->json([
        'status' => 'exito',
        'mensaje' => 'Eye of Odin ha recibido los datos correctamente'
    ], 200);
});
