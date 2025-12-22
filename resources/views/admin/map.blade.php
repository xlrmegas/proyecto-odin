<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radar Térmico - Odín Intelligence</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        body { background-color: #0b0d0f; color: white; overflow: hidden; margin: 0; font-family: 'Courier New', monospace; }
        
        .radar-header {
            background: #121212;
            padding: 10px 25px;
            border-bottom: 2px solid #ff4136;
            height: 70px;
            position: relative;
            z-index: 1001;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #map-heatmap { 
            height: calc(100vh - 70px); 
            width: 100%; 
            background: #000;
        }

        /* Capa oscura para el mapa */
        .dark-map { filter: invert(100%) hue-rotate(180deg) brightness(95%) contrast(90%); }

        /* Estilo de los marcadores individuales (puntos tácticos) */
        .target-dot {
            width: 8px;
            height: 8px;
            background-color: #00ff00;
            border-radius: 50%;
            border: 1px solid white;
            box-shadow: 0 0 10px #00ff00;
        }

        .leaflet-popup-content-wrapper {
            background: #1a1c1e !important;
            color: #fff !important;
            border: 1px solid #ff4136;
            border-radius: 0;
        }
        
        .legend {
            position: absolute;
            bottom: 30px;
            left: 20px;
            background: rgba(0,0,0,0.8);
            padding: 10px;
            border: 1px solid #ff4136;
            z-index: 1000;
            font-size: 12px;
        }
    </style>
</head>
<body>

    <div class="radar-header">
        <div>
            <h2 class="m-0 font-weight-bold" style="letter-spacing: 2px; color: #ff4136;">MAPA DE CALOR TÁCTICO</h2>
            <small class="text-success"><i class="fas fa-fire mr-1"></i> DETECTANDO DENSIDAD DE OBJETIVOS...</small>
        </div>
        <div>
            <a href="{{ route('odin.list') }}" class="btn btn-outline-danger btn-sm">
                <i class="fas fa-list mr-1"></i> VOLVER AL ARCHIVO
            </a>
        </div>
    </div>

    <div id="map-heatmap"></div>

    <div class="legend">
        <div class="mb-1"><i class="fas fa-circle text-danger"></i> Alta Densidad</div>
        <div class="mb-1"><i class="fas fa-circle text-warning"></i> Densidad Media</div>
        <div><i class="fas fa-circle text-success"></i> Objetivo Único</div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://leaflet.github.io/Leaflet.heat/dist/leaflet-heat.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar mapa
            const map = L.map('map-heatmap', { zoomControl: false }).setView([7.0, -66.0], 6);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                className: 'dark-map'
            }).addTo(map);

            const heatLayer = L.heatLayer([], {
                radius: 25,
                blur: 15,
                maxZoom: 10,
                gradient: {0.4: 'blue', 0.65: 'lime', 1: 'red'}
            }).addTo(map);

            const markerGroup = L.layerGroup().addTo(map);

           function updateHeatMap() {
    fetch('/admin/map-data')
        .then(response => response.json())
        .then(data => {
            console.log("Datos cargados:", data); // Mira la consola (F12) para ver si el registro llega
            markerGroup.clearLayers();
            const heatPoints = [];

            data.forEach(p => {
                heatPoints.push([p.lat, p.lng, 0.7]); // Añade al mapa de calor

                // Añade el marcador táctico
                L.marker([p.lat, p.lng], { 
                    icon: L.divIcon({ className: 'target-dot', iconSize: [10, 10] }) 
                })
                .addTo(markerGroup)
                .bindPopup(`<b>ID: ${p.id}</b><br>IP: ${p.ip}`);
            });
            heatLayer.setLatLngs(heatPoints);
        });
}

            updateHeatMap();
            setInterval(updateHeatMap, 30000); // Actualizar cada 30 segundos
            L.control.zoom({ position: 'bottomright' }).addTo(map);
        });
    </script>
</body>
</html>