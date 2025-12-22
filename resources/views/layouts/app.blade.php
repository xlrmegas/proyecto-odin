<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Eye of Odin | Sistema de Vigilancia</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Source+Sans+Pro:wght@300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background: #050505 url('https://images.unsplash.com/photo-1534088568595-a066f410bcda?q=80&w=2000&auto=format&fit=crop') no-repeat center center fixed !important;
            background-size: cover !important;
        }

        .wrapper::before {
            content: ""; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.75); z-index: 0;
        }

        .content-wrapper { background: transparent !important; position: relative; z-index: 1; }

        /* Sidebar Glassmorphism */
        .main-sidebar { 
            background: rgba(10, 10, 10, 0.9) !important; 
            backdrop-filter: blur(15px); 
            border-right: 1px solid rgba(197, 160, 89, 0.3) !important;
        }

        .brand-link { 
            border-bottom: 1px solid rgba(197, 160, 89, 0.3) !important; 
            color: #c5a059 !important; 
            font-family: 'Cinzel', serif;
            letter-spacing: 2px;
        }

        .main-header {
            background: rgba(0, 0, 0, 0.6) !important;
            border-bottom: 1px solid rgba(197, 160, 89, 0.2) !important;
            backdrop-filter: blur(10px);
        }

        /* Sidebar Links XL */
        .nav-sidebar .nav-link {
            color: #ffffff !important;
            font-size: 1.15rem !important;
            padding: 12px 20px !important;
            margin-bottom: 5px;
        }

        .nav-sidebar .nav-link i { color: #c5a059 !important; font-size: 1.3rem; }

        .nav-sidebar .nav-link.active {
            background-color: rgba(197, 160, 89, 0.2) !important;
            border-left: 4px solid #c5a059;
        }

        /* Protocolo Rojo - Botón */
        .btn-emergency {
            border: 2px solid #dc3545;
            color: #dc3545;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-emergency.active {
            background-color: #dc3545 !important;
            color: white !important;
            box-shadow: 0 0 15px #dc3545;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <nav class="main-header navbar navbar-expand navbar-dark border-0">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-[#c5a059]" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto align-items-center">
                <li class="nav-item">
                    <button id="emergencyBtn" class="btn btn-emergency mr-3">
                        <i class="fas fa-skull-crossbones mr-2"></i> PROTOCOLO ROJO
                    </button>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link text-white font-bold">SALIR</button>
                    </form>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ route('dashboard') }}" class="brand-link text-center">
                <span class="brand-text font-weight-bold">EL OJO DE ODÍN</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="info text-white font-bold ml-3">
                        {{ Auth::user()->name }}
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column">
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Panel de Control</p>
                            </a>
                        </li>
                      <li class="nav-item">
                    <a href="{{ route('odin.map') }}" class="nav-link {{ request()->routeIs('odin.map') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-map-marked-alt text-danger"></i>
                        <p>Mapa Geográfico</p>
                    </a>
                      </li>
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-shield"></i>
                                <p>Gestión de Vigías</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('users.create') }}" class="nav-link {{ request()->routeIs('users.create') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-bolt"></i>
                                <p>Invocar Guerrero</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <main class="content pt-4">
                <div class="container-fluid">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

    <script>
        document.getElementById('emergencyBtn').addEventListener('click', function() {
            this.classList.toggle('active');
            const isAlert = this.classList.contains('active');
            
            // Emitir evento para el Dashboard
            const event = new CustomEvent('protocoloRojo', { detail: { active: isAlert } });
            window.dispatchEvent(event);
            
            if(isAlert) {
                this.innerHTML = '<i class="fas fa-radiation fa-spin mr-2"></i> DESACTIVAR ALERTA';
            } else {
                this.innerHTML = '<i class="fas fa-skull-crossbones mr-2"></i> PROTOCOLO ROJO';
            }
        });
    </script>
</body>
</html>