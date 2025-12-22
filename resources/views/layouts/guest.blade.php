<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Acceso Vigía - Odín</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=cinzel:700|figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                background: url('/ruta-a-tu-imagen-nubes.jpg') no-repeat center center fixed;
                background-size: cover;
                font-family: 'Figtree', sans-serif;
            }
            .auth-card {
                background: rgba(18, 18, 18, 0.95) !important;
                border: 1px solid #c5a059 !important;
                box-shadow: 0 0 30px rgba(0,0,0,0.9);
            }
            .odin-logo {
                font-family: 'Cinzel', serif;
                color: #c5a059;
                text-shadow: 0 0 10px rgba(197, 160, 89, 0.5);
                letter-spacing: 4px;
            }
            input {
                background-color: #000 !important;
                border: 1px solid #333 !important;
                color: #fff !important;
            }
            input:focus {
                border-color: #c5a059 !important;
                ring: 1px solid #c5a059 !important;
            }
            .btn-odin {
                background: #c5a059 !important;
                color: #000 !important;
                font-weight: bold !important;
                text-transform: uppercase;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div>
                <a href="/">
                    <h1 class="odin-logo text-4xl">ODÍN</h1>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-8 auth-card overflow-hidden">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>