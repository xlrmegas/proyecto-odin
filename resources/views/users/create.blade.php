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
            transition: opacity 0.5s ease;
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
        }

        .odin-input:focus {
            border-color: #c5a059 !important;
            box-shadow: 0 0 15px rgba(197, 160, 89, 0.4) !important;
        }

        /* Botón con estado de carga */
        .btn-summon {
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
            position: relative;
            overflow: hidden;
        }

        .btn-summon:disabled {
            background: #444 !important;
            color: #888 !important;
            cursor: not-allowed;
        }

        /* Animación de Runa Giratoria */
        .loading-rune {
            display: none;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Clase para desvanecer el formulario */
        .processing {
            opacity: 0.3;
            pointer-events: none;
        }
    </style>

    <div class="content-header">
        <div class="container-fluid text-center">
            <h1 class="odin-title mb-5">INVOCAR VIGÍA</h1>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="terminal-card" id="invocation-form-container">
                    <form id="summonForm" action="#" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 form-group mb-4">
                                <label class="odin-label">Nombre del Guerrero</label>
                                <input type="text" name="name" class="form-control odin-input" placeholder="Ej. Ragnar Lothbrok" required>
                            </div>

                            <div class="col-md-12 form-group mb-4">
                                <label class="odin-label">Canal Espiritual (Email)</label>
                                <input type="email" name="email" class="form-control odin-input" placeholder="guerrero@odin.com" required>
                            </div>

                            <div class="col-md-6 form-group mb-4">
                                <label class="odin-label">Rango</label>
                                <select name="role" class="form-control odin-input">
                                    <option value="user">Explorador (Usuario)</option>
                                    <option value="admin">Gran Vigía (Admin)</option>
                                </select>
                            </div>

                            <div class="col-md-6 form-group mb-4">
                                <label class="odin-label">Clave Ancestral</label>
                                <input type="password" name="password" class="form-control odin-input" placeholder="********" required>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn-summon" id="btnSubmit">
                                <span id="btnText"><i class="fas fa-bolt mr-2"></i> Confirmar Invocación</span>
                                <span id="btnLoading" style="display: none;">
                                    <i class="fas fa-eye loading-rune mr-2" style="display: inline-block;"></i> SINCRONIZANDO RUNA...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('summonForm').addEventListener('submit', function(e) {
            // Evitamos el envío inmediato para ver la animación
            // Si ya tienes el backend listo, quita el e.preventDefault()
            e.preventDefault(); 

            const btnText = document.getElementById('btnText');
            const btnLoading = document.getElementById('btnLoading');
            const btnSubmit = document.getElementById('btnSubmit');
            const container = document.getElementById('invocation-form-container');

            // 1. Cambiamos el estado del botón
            btnText.style.display = 'none';
            btnLoading.style.display = 'block';
            btnSubmit.disabled = true;

            // 2. Aplicamos efecto visual al contenedor
            container.classList.add('processing');

            // 3. Simulamos la respuesta del Valhalla (3 segundos)
            setTimeout(() => {
                alert("Runa sincronizada. El Guerrero ha sido invocado con éxito.");
                // Aquí podrías redirigir o limpiar el formulario
                // this.submit(); // Descomenta esto para enviar el formulario de verdad
                window.location.href = "{{ route('dashboard') }}";
            }, 3000);
        });
    </script>
</x-app-layout>