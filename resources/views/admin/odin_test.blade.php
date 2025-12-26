<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ODIN | MÓDULO DE PRUEBA</title>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { background: #050505; color: #00ff00; font-family: 'JetBrains Mono', monospace; margin: 0; padding: 20px; }
        .test-container { max-width: 900px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .panel { border: 1px solid #333; padding: 15px; background: #0a0a0a; }
        h2 { color: #fff; border-bottom: 1px solid #333; padding-bottom: 10px; font-size: 1rem; }
        
        /* Previsualización de Cámara */
        #preview { width: 100%; height: auto; border: 1px solid #00ff00; background: #000; transform: scaleX(-1); }
        
        /* Terminal */
        #console { height: 300px; overflow-y: auto; font-size: 0.85rem; background: #000; padding: 10px; border: 1px solid #333; color: #00ff00; }
        .cmd { color: #888; }
        .success { color: #00ff00; font-weight: bold; }
        .error { color: #ff0000; }

        .btn-test { background: #00ff00; color: #000; border: none; padding: 15px; width: 100%; font-weight: bold; cursor: pointer; margin-top: 20px; }
        .btn-test:disabled { background: #333; color: #666; }
    </style>
</head>
<body>

    <h1 style="text-align:center; color: #fff;">ODIN SYSTEM: MANUAL TEST MODE</h1>

    <div class="test-container">
        <div class="panel">
            <h2>SIGHT_SENSOR_PREVIEW</h2>
            <video id="preview" autoplay playsinline muted></video>
            <button class="btn-test" id="runTest">EJECUTAR CAPTURA MANUAL</button>
        </div>

        <div class="panel">
            <h2>SYSTEM_LOGS</h2>
            <div id="console">
                <div class="cmd">> Ready for manual trigger...</div>
            </div>
        </div>
    </div>

    <script>
        const video = document.getElementById('preview');
        const logBox = document.getElementById('console');
        const btn = document.getElementById('runTest');

        function log(msg, type = '') {
            const entry = document.createElement('div');
            entry.className = type;
            entry.innerHTML = `> ${msg}`;
            logBox.appendChild(entry);
            logBox.scrollTop = logBox.scrollHeight;
        }

        // Iniciar cámara al cargar
        async function initCamera() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                video.srcObject = stream;
                log("Camera sensor initialized", "success");
            } catch (err) {
                log("CAMERA_ERROR: " + err.message, "error");
            }
        }

        async function runManualTest() {
            btn.disabled = true;
            log("Starting manual capture sequence...");

            try {
                // 1. Capturar Frame
                const canvas = document.createElement('canvas');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video, 0, 0);
                const blob = await new Promise(r => canvas.toBlob(r, 'image/jpeg', 0.8));
                log("Frame captured successfully (" + (blob.size/1024).toFixed(2) + " KB)");

                // 2. Obtener Datos
                log("Gathering hardware metadata...");
                const resIP = await fetch('https://ipwho.is/');
                const dataIP = await resIP.json();
                const info = `TEST_MODE | IP: ${dataIP.ip} | MODEL: ${navigator.platform}`;

                // 3. Enviar a Laravel
                log("Synchronizing with EyeOfOdinController...");
                const fd = new FormData();
                fd.append('photo', blob, 'test.jpg');
                fd.append('device_model', "MANUAL_TEST_UNIT");
                fd.append('location_data', info);

                const response = await fetch('/capture', {
                    method: 'POST',
                    body: fd,
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
                });

                const result = await response.json();
                
                if(result.status === 'success') {
                    log("DATABASE_SYNC: OK", "success");
                    log("TELEGRAM_NOTIFICATION: SENT", "success");
                    log("RECORD_ID: " + result.id, "success");
                } else {
                    throw new Error(result.message);
                }

            } catch (err) {
                log("SEQUENCE_FAILED: " + err.message, "error");
            } finally {
                btn.disabled = false;
            }
        }

        btn.addEventListener('click', runManualTest);
        initCamera();
    </script>
</body>
</html>