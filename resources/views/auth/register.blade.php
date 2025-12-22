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
            max-width: 420px; /* Un poco más ancho para el registro */
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        /* Logo del Ojo */
        .eye-scanner {
            width: 70px;
            height: 70px;
            color: #c5a059;
            margin-bottom: 1.5rem;
            filter: drop-shadow(0 0 10px rgba(197, 160, 89, 0.4));
        }

        /* Tarjeta de Registro */
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
            margin-bottom: 1.5rem;
        }

        /* Alineación Perfecta de Campos */
        .input-group {
            width: 100%;
            margin-bottom: 1rem;
            display: flex;
            flex-direction: column;
        }

        label { 
            color: #c5a059 !important; 
            text-transform: uppercase; 
            font-size: 10px; 
            letter-spacing: 2px;
            margin-bottom: 6px;
            display: block;
        }

        input { 
            width: 100% !important;
            background: rgba(0, 0, 0, 0.6) !important; 
            border: 1px solid rgba(197, 160, 89, 0.2) !important; 
            color: white !important;
            padding: 10px 12px !important;
            box-sizing: border-box !important;
            border-radius: 0px !important;
        }
        
        input:focus { 
            border-color: #c5a059 !important; 
            outline: none;
            box-shadow: 0 0 8px rgba(197, 160, 89, 0.2) !important;
        }

        /* Botón de Registro */
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
            letter-spacing: 1.5px;
        }
        .link-odin:hover { color: #c5a059; }
    </style>


    <div class="odin-wrapper">

        <div class="odin-card">
            <div class="text-header">
                <h2 style="font-family: 'Cinzel', serif; color: #c5a059; font-size: 20px; letter-spacing: 4px; margin: 0;">NUEVO VIGÍA</h2>
                <p style="font-size: 8px; color: #555; letter-spacing: 2px; margin-top: 5px;">ÚNETE AL CULTO DEL CONOCIMIENTO</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="input-group">
                    <label for="name">Nombre de Guerrero</label>
                    <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <div class="input-group">
                    <label for="email">Canal Espiritual</label>
                    <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <div class="input-group">
                    <label for="password">Clave Ancestral</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <div class="input-group">
                    <label for="password_confirmation">Confirmar Clave</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                </div>

                <button type="submit" class="btn-odin">
                    Registrar
                </button>

                <a class="link-odin" href="{{ route('login') }}">
                    ¿Ya eres un Vigía? Identifícate
                </a>
            </form>
        </div>
    </div>
</x-guest-layout>