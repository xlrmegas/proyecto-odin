<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica', sans-serif; background: #fff; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #c5a059; padding-bottom: 10px; }
        .title { color: #c5a059; font-size: 24px; margin: 0; }
        .photo { text-align: center; margin: 20px 0; }
        .photo img { width: 300px; border: 5px solid #000; }
        .data-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .data-table td { padding: 10px; border: 1px solid #ddd; }
        .label { font-weight: bold; background: #f9f9f9; width: 30%; }
        .footer { margin-top: 50px; font-size: 10px; text-align: center; color: #777; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">EXPEDIENTE DE VIGILANCIA: EL OJO DE ODÍN</h1>
        <p>ID DE CAPTURA: #{{ $target->id }} | FECHA: {{ $target->created_at }}</p>
    </div>

    <div class="photo">
        <img src="{{ public_path($target->photo_path) }}" alt="Captura">
    </div>

    <table class="data-table">
        <tr>
            <td class="label">DIRECCIÓN IP</td>
            <td>{{ $target->ip }}</td>
        </tr>
        <tr>
            <td class="label">DISPOSITIVO</td>
            <td>{{ $target->user_agent }}</td>
        </tr>
        <tr>
            <td class="label">DATOS DE UBICACIÓN</td>
            <td>{{ $target->location }}</td>
        </tr>
    </table>

    <div class="footer">
        ESTE DOCUMENTO ES PROPIEDAD DEL SISTEMA CENTRAL VALHALLA. CONFIDENCIAL.
    </div>
</body>
</html>