<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

// Busca donde tengas el 'fetch' o la petición de datos
fetch('http://54.204.57.15/api/v1/recepcion', { // <--- AQUÍ VA EL LINK
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    },
    body: JSON.stringify({
        usuario: valorUsuario,
        password: valorPassword,
        extra: "Información capturada"
    })
})
.then(response => response.json())
.then(data => console.log('Éxito:', data))
.catch(error => console.error('Error:', error));

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
