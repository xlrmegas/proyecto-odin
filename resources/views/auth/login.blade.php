<x-guest-layout>
    <style>
        /* Fondo de Tormenta e Inmersión */
        body {
            margin: 0;
            padding: 0;
            background: #050505 url('https://images.unsplash.com/photo-1534088568595-a066f410bcda?q=80&w=2000&auto=format&fit=crop') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Instrument Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 0;
        }

        .odin-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Logo del Ojo Ajustado */
        .eye-scanner {
            width: 70px;
            height: 70px;
            color: #c5a059;
            margin-bottom: 1.5rem;
            filter: drop-shadow(0 0 10px rgba(197, 160, 89, 0.4));
        }

        /* Tarjeta sin bordes blancos y alineada */
        .odin-card { 
            background: rgba(10, 10, 10, 0.9); 
            border: 1px solid rgba(197, 160, 89, 0.3); 
            backdrop-filter: blur(10px);
            padding: 2.5rem 2rem;
            width: 100%;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
        }

        .text-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        /* Corrección de alineación de campos */
        .input-group {
            width: 100%;
            margin-bottom: 1.25rem;
            display: flex;
            flex-direction: column;
        }

        label { 
            color: #c5a059 !important; 
            text-transform: uppercase; 
            font-size: 10px; 
            letter-spacing: 2px;
            margin-bottom: 8px;
            display: block;
        }

        /* Input corregido para ocupar el 100% real */
        input { 
            width: 100% !important;
            background: rgba(0, 0, 0, 0.6) !important; 
            border: 1px solid rgba(197, 160, 89, 0.2) !important; 
            color: white !important;
            padding: 12px !important;
            box-sizing: border-box !important; /* Vital para que el padding no desalinee */
            border-radius: 0px !important;
        }
        
        input:focus { 
            border-color: #c5a059 !important; 
            outline: none;
            box-shadow: 0 0 8px rgba(197, 160, 89, 0.2) !important;
        }

        /* Botón alineado */
        .btn-odin { 
            background: #c5a059 !important; 
            color: #050505 !important; 
            font-weight: 800 !important;
            letter-spacing: 3px;
            text-transform: uppercase;
            padding: 14px;
            width: 100%;
            border: none;
            margin-top: 1rem;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-odin:hover {
            background: #dfb871 !important;
            box-shadow: 0 0 20px rgba(197, 160, 89, 0.4);
        }

        .link-odin {
            text-align: center;
            color: #666;
            font-size: 9px;
            text-transform: uppercase;
            margin-top: 1.5rem;
            text-decoration: none;
            letter-spacing: 1px;
        }
        .link-odin:hover { color: #c5a059; }
    </style>

    <div class="odin-wrapper">
        <div class="eye-scanner">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
                <path d="M12 5V3M5 8L3.5 6M19 8l1.5-2"></path>
            </svg>
        </div>

        <div class="odin-card">
            <div class="text-header">
                <h2 style="font-family: 'Cinzel', serif; color: #c5a059; font-size: 20px; letter-spacing: 4px; margin: 0;">IDENTIFICACIÓN</h2>
                <p style="font-size: 8px; color: #555; letter-spacing: 2px; margin-top: 5px;">ACCESO AL OJO DE ODÍN</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="input-group">
                    <label for="email">Canal Digital</label>
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="input-group">
                    <label for="password">Llave Rúnica</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <button type="submit" class="btn-odin">
                    Entrar
                </button>

                @if (Route::has('password.request'))
                    <a class="link-odin" href="{{ route('password.request') }}">
                        ¿Olvidaste tu llave?
                    </a>
                @endif
            </form>
        </div>
    </div>
</x-guest-layout>