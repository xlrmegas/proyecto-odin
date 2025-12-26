<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* Títulos y Encabezados */
        .content-header h1 { 
            color: #ffffff !important; 
            font-size: 2.5rem !important; 
            text-shadow: 2px 2px 8px rgba(0,0,0,0.9);
            font-family: 'Cinzel', serif;
            letter-spacing: 3px;
        }

        /* Small Boxes Estilo Odín */
        .small-box .inner h3 { 
            font-size: 3rem !important; 
            color: #ffffff !important; 
            text-shadow: 1px 1px 5px rgba(0,0,0,0.5);
        }
        .small-box .inner p { 
            font-size: 1.3rem !important; 
            color: #ffffff !important;
            font-weight: 700;
            text-transform: uppercase;
        }

        /* Widget de Prueba Odin (Especial) */
        .bg-odin-test {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%) !important;
            border: 1px solid #818cf8 !important;
        }

        /* Tabla Estilo Valhalla */
        .card-odin {
            background: rgba(10, 10, 10, 0.85) !important;
            border: 1px solid rgba(197, 160, 89, 0.4) !important;
            backdrop-filter: blur(10px);
        }
        .table thead th { 
            font-size: 15px !important; 
            color: #c5a059 !important; 
            background: rgba(0,0,0,0.4);
            border-bottom: 2px solid #c5a059 !important;
        }
        .table tbody td { 
            color: #ffffff !important; 
            font-size: 1.2rem !important; 
            border-top: 1px solid rgba(197,160,89,0.1) !important;
            padding: 15px !important;
        }

        /* Consola de Sistema Operativo */
        .console-box {
            background: rgba(0,0,0,0.8) !important; 
            border-left: 5px solid #c5a059 !important;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.6);
        }
        .console-box strong, .console-box span {
            color: #ffffff !important; 
            font-size: 1.4rem !important;
            font-family: 'Courier New', Courier, monospace;
        }

        /* Cursor de Terminal Animado */
        .cursor-terminal {
            display: inline-block; width: 12px; height: 24px;
            background-color: #c5a059; margin-left: 8px;
            animation: parpadeo 1.2s infinite; vertical-align: middle;
        }
        @keyframes parpadeo { 0% { opacity: 0; } 50% { opacity: 1; } 100% { opacity: 0; } }

        .chart-container { position: relative; height: 300px; width: 100%; }
    </style>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-eye mr-3"></i>MONITOR DE VIGILANCIA</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-6">
            <div class="small-box bg-dark shadow-lg border border-[#c5a059]/50">
                <div class="inner">
                    <h3>150</h3>
                    <p>Vigías Totales</p>
                </div>
                <div class="icon"><i class="fas fa-users text-[#c5a059]"></i></div>
                <a href="{{ route('users.index') }}" class="small-box-footer" style="color: #c5a059 !important; font-size: 1.1rem;">
                    Gestionar Usuarios <i class="fas fa-arrow-circle-right ml-2"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-4 col-6">
            <div class="small-box bg-odin-test shadow-lg">
                <div class="inner">
                    <h3 class="text-white">PROBAR</h3>
                    <p class="text-white">Local


                </div>
                <div class="icon"><i class="fas fa-fingerprint" style="color: rgba(255,255,255,0.2)"></i></div>
                <a href="{{ route('odin.test') }}" class="small-box-footer" style="background: rgba(0,0,0,0.2) !important; color: #818cf8 !important; font-weight: bold;">
                    INICIAR MI ESCANEO <i class="fas fa-bolt ml-2"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-4 col-6">
            <div class="small-box bg-dark shadow-lg border border-[#c5a059]/50">
                <div class="inner">
                    <h3><i class="fas fa-plus-circle"></i></h3>
                    <p>Invocar Guerrero</p>
                </div>
                <div class="icon"><i class="fas fa-bolt text-[#c5a059]"></i></div>
                <a href="{{ route('users.create') }}" class="small-box-footer" style="color: #c5a059 !important; font-size: 1.1rem;">
                    Iniciar Invocación <i class="fas fa-arrow-circle-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card card-odin">
                <div class="card-header border-0">
                    <h3 class="card-title text-white font-bold uppercase tracking-widest">
                        <i class="fas fa-chart-line mr-2"></i> Flujo de Energía Rúnica (Actividad)
                    </h3>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="runicChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <div class="card card-odin shadow-xl">
                <div class="card-header border-bottom border-[#c5a059]/20">
                    <h3 class="card-title uppercase tracking-widest font-bold text-white">
                        <i class="fas fa-history mr-2"></i> Registros Recientes del Valhalla
                    </h3> 
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>RUNA ID</th>
                                <th>Funcionario</th>
                                <th>ESTADO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($targets ?? [] as $t) 
                            <tr>
                                <td>#{{ $t->id }}</td>
                                <td class="font-bold text-white">Captura Automática</td>
                                <td><span class="badge badge-danger px-3 py-2" style="font-size: 0.9rem;">DETECTADO</span></td>
                                <td>
                                    <a href="{{ route('odin.show', $t->id) }}" class="btn btn-sm btn-warning mr-2">
                                        <i class="fas fa-eye"></i> VER
                                    </a>
                                    <a href="{{ route('odin.pdf', $t->id) }}" class="btn btn-sm btn-danger">
                                        <i class="fas fa-file-pdf"></i> PDF
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            
                            @if(count($targets ?? []) == 0)
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">No hay capturas registradas en el Ojo de Odín</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5 mb-5">
        <div class="col-12">
            <div class="console-box">
                <p>
                    <strong>SISTEMA OPERATIVO:</strong> 
                    <span>Los protocolos de vigilancia del Ojo de Odín se están ejecutando con normalidad. 
                    Todas las runas de datos están sincronizadas con el núcleo central. Vigilancia activa...</span>
                    <div class="cursor-terminal"></div>
                </p>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('runicChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom'],
                datasets: [{
                    label: 'Incursiones',
                    data: [12, 19, 15, 25, 22, 30, 28],
                    borderColor: '#c5a059',
                    backgroundColor: 'rgba(197, 160, 89, 0.1)',
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointRadius: 5,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { labels: { color: '#ffffff', font: { size: 14 } } } },
                scales: {
                    y: { grid: { color: 'rgba(255, 255, 255, 0.1)' }, ticks: { color: '#ffffff' } },
                    x: { grid: { color: 'rgba(255, 255, 255, 0.1)' }, ticks: { color: '#ffffff' } }
                }
            }
        });
    </script>
</x-app-layout>