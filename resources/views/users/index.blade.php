<x-app-layout>
    <style>
        /* Títulos y Encabezados */
        .content-header h1 { 
            color: #ffffff !important; 
            font-size: 2.5rem !important; 
            font-family: 'Cinzel', serif; 
            text-shadow: 2px 2px 8px rgba(0,0,0,0.8);
        }

        /* Card con efecto Glassmorphism */
        .card-odin {
            background: rgba(10, 10, 10, 0.9) !important;
            border: 1px solid rgba(197, 160, 89, 0.4) !important;
            backdrop-filter: blur(15px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        /* Estilo de Tabla de Alta Visibilidad */
        .table-odin thead th {
            color: #c5a059 !important;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 15px !important;
            border-bottom: 2px solid #c5a059 !important;
            background: rgba(0,0,0,0.4);
        }

        .table-odin tbody td {
            color: #ffffff !important;
            font-size: 1.3rem !important; /* Letra grande para leer guerreros */
            vertical-align: middle !important;
            padding: 20px !important;
            border-top: 1px solid rgba(197,160,89,0.1) !important;
        }

        /* Botones de Acción */
        .btn-odin-action {
            border: 1px solid #c5a059;
            color: #c5a059;
            background: transparent;
            padding: 8px 15px;
            transition: 0.3s;
            font-weight: bold;
        }

        .btn-odin-action:hover {
            background: #c5a059;
            color: #000;
            box-shadow: 0 0 10px #c5a059;
        }

        /* Alertas de Éxito */
        .alert-odin {
            background: rgba(197, 160, 89, 0.15) !important;
            border: 1px solid #c5a059 !important;
            color: #ffffff !important;
            font-size: 1.1rem;
        }
    </style>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4 align-items-center">
                <div class="col-sm-6">
                    <h1>GESTIÓN DE VIGÍAS</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('users.create') }}" class="btn btn-odin-action" style="background: #c5a059; color: #000; font-size: 1.1rem;">
                        <i class="fas fa-plus-circle mr-2"></i> INVOCAR NUEVO GUERRERO
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-odin alert-dismissible fade show mb-4">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                <button type="button" class="close text-white" data-dismiss="alert">&times;</button>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card card-odin">
                    <div class="card-header border-0">
                        <h3 class="card-title text-white font-bold uppercase tracking-widest">
                            <i class="fas fa-shield-alt mr-2 text-[#c5a059]"></i> Guerreros Registrados en el Valhalla
                        </h3>
                    </div>
                    
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-odin text-nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre del Guerrero</th>
                                    <th>Identificador (Email)</th>
                                    <th>Estado de Runa</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td class="font-mono text-warning">#{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td class="font-weight-bold">{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge badge-success px-3 py-2" style="font-size: 0.9rem;">ACTIVO</span>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-odin-action mr-2" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('¿Enviar a este guerrero al Helheim (Eliminar)?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-odin-action border-danger text-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5 mb-4">
            <div class="col-12 text-center text-white-50">
                <p style="font-family: 'Courier New', Courier, monospace; letter-spacing: 2px;">
                    <i class="fas fa-eye mr-2"></i> SISTEMA DE VIGILANCIA CENTRALIZADA - EL OJO DE ODÍN v1.0
                </p>
            </div>
        </div>
    </div>
</x-app-layout>