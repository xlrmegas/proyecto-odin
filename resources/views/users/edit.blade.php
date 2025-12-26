<x-app-layout>
    <style>
        .odin-title { 
            color: #ffffff !important; 
            font-family: 'Cinzel', serif; 
            font-size: 2.5rem !important; 
            letter-spacing: 5px;
            text-shadow: 0 0 15px rgba(197, 160, 89, 0.5);
        }

        .terminal-card {
            background: rgba(10, 10, 10, 0.85) !important;
            border: 2px solid #c5a059 !important;
            box-shadow: 0 0 30px rgba(0, 0, 0, 1);
            backdrop-filter: blur(15px);
            padding: 40px;
            border-radius: 8px;
        }

        .odin-label {
            color: #ffffff !important;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: bold;
            font-size: 1.1rem !important;
            margin-bottom: 10px;
        }

        .odin-input {
            background: rgba(0, 0, 0, 0.7) !important;
            border: 1px solid rgba(197, 160, 89, 0.3) !important;
            color: #ffffff !important;
            font-size: 1.2rem !important;
            padding: 15px !important;
            border-radius: 0 !important;
            transition: 0.4s;
        }

        .odin-input:focus {
            border-color: #c5a059 !important;
            box-shadow: 0 0 15px rgba(197, 160, 89, 0.4) !important;
        }

        .btn-update {
            background: #c5a059 !important;
            color: #000000 !important;
            font-weight: 900 !important;
            font-size: 1.3rem !important;
            letter-spacing: 3px;
            text-transform: uppercase;
            padding: 15px !important;
            border: none;
            width: 100%;
            transition: 0.3s;
        }

        .btn-update:hover {
            background: #ffffff !important;
            box-shadow: 0 0 25px #c5a059;
        }

        .loading-rune { display: none; animation: spin 2s linear infinite; }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    </style>

    <div class="content-header">
        <div class="container-fluid text-center">
            <h1 class="odin-title mb-5 text-uppercase">Modificar Runas de {{ $user->name }}</h1>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="terminal-card" id="edit-form-container">
                    <form id="editForm" action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-12 form-group mb-4">
                                <label class="odin-label">Nombre del Guerrero</label>
                                <input type="text" name="name" class="form-control odin-input" value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="col-md-12 form-group mb-4">
                                <label class="odin-label">Canal Espiritual (Email)</label>
                                <input type="email" name="email" class="form-control odin-input" value="{{ old('email', $user->email) }}" required>
                            </div>

                            <div class="col-md-12 mb-4">
                                <div class="p-3 bg-black border border-warning/20 rounded">
                                    <p class="text-warning mb-0" style="font-size: 0.9rem;">
                                        <i class="fas fa-exclamation-triangle mr-2"></i> 
                                        La clave ancestral solo puede ser restablecida por el propio guerrero desde su portal de seguridad.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn-update" id="btnSubmit">
                                <span id="btnText"><i class="fas fa-sync-alt mr-2"></i> Actualizar Registros</span>
                                <span id="btnLoading" style="display: none;">
                                    <i class="fas fa-eye loading-rune mr-2" style="display: inline-block;"></i> REESCRIBIENDO RUNA...
                                </span>
                            </button>
                            <a href="{{ route('users.index') }}" class="btn btn-link btn-block mt-3 text-white uppercase" style="letter-spacing: 2px;">
                                <i class="fas fa-chevron-left mr-2"></i> Volver a la Lista
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('editForm').addEventListener('submit', function() {
            const btnText = document.getElementById('btnText');
            const btnLoading = document.getElementById('btnLoading');
            const btnSubmit = document.getElementById('btnSubmit');
            const container = document.getElementById('edit-form-container');

            btnText.style.display = 'none';
            btnLoading.style.display = 'block';
            btnSubmit.disabled = true;
            container.style.opacity = '0.5';
        });
    </script>
</x-app-layout>