<!DOCTYPE html>
<html lang="<?php echo str_replace('_', '-', app()->getLocale()); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eye of Odin</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cinzel:700|instrument-sans:400,500" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --odin-gold: #c5a059;
            --odin-dark: #050505;
            --eye-glow: rgba(197, 160, 89, 0.15);
        }

        body {
            background-color: var(--odin-dark);
            color: #ffffff;
            font-family: 'Instrument Sans', sans-serif;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            overflow: hidden;
        }

        /* El Ojo de Odín - Efecto de Orbe Pulsante */
        .eye-sphere {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, var(--eye-glow) 0%, transparent 70%);
            border: 1px solid rgba(197, 160, 89, 0.05);
            border-radius: 50%;
            z-index: -1;
            animation: pulse-eye 10s infinite ease-in-out;
        }

        @keyframes pulse-eye {
            0%, 100% { transform: scale(1); opacity: 0.3; }
            50% { transform: scale(1.1); opacity: 0.6; }
        }

        /* Línea de escaneo sutil */
        .scan-line {
            position: absolute;
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--odin-gold), transparent);
            top: 50%;
            opacity: 0.2;
            animation: scan 4s infinite linear;
            z-index: 0;
        }

        @keyframes scan {
            0% { top: 0%; }
            100% { top: 100%; }
        }

        .odin-title {
            font-family: 'Cinzel', serif;
            letter-spacing: 0.6em;
            color: var(--odin-gold);
            text-shadow: 0 0 20px rgba(197, 160, 89, 0.4);
        }

        /* Botones con lógica de PHP Nativo */
        .btn-odin {
            display: block;
            width: 280px;
            padding: 15px;
            margin: 15px auto;
            text-align: center;
            border: 1px solid var(--odin-gold);
            color: var(--odin-gold);
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.3em;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(8px);
            position: relative;
            z-index: 10;
        }

        .btn-odin:hover {
            background: var(--odin-gold);
            color: var(--odin-dark);
            box-shadow: 0 0 30px var(--odin-gold);
            transform: translateY(-2px);
        }

        .rune {
            color: var(--odin-gold);
            font-family: 'Cinzel';
            font-size: 2.2rem;
            opacity: 0.4;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <div class="eye-sphere"></div>
    <div class="scan-line"></div>

    <div class="text-center z-10 px-6">
        <div class="rune">ᛟ</div>
        
        <h1 class="odin-title text-4xl md:text-7xl font-bold mb-4 uppercase">
            Eye of Odin
        </h1>
        
        <p class="text-gray-500 tracking-[0.8em] text-[10px] mb-12 uppercase italic">
            El conocimiento exige sacrificio
        </p>

        <div class="navigation">
            <?php if (auth()->check()): ?>
                <a href="<?php echo url('/dashboard'); ?>" class="btn-odin">
                    Acceder al Oráculo
                </a>
            <?php else: ?>
                <a href="<?php echo url('/login'); ?>" class="btn-odin">
                    Iniciar Sesión
                </a>

            <?php endif; ?>
        </div>

        <div class="rune" style="margin-top: 50px;">ᚦ</div>
    </div>

    <footer class="absolute bottom-8 w-full text-center text-[8px] text-gray-700 tracking-[0.6em] uppercase">
        <?php echo date('Y'); ?> &bull; OMNISCIENT SYSTEM
    </footer>

</body>
</html>
