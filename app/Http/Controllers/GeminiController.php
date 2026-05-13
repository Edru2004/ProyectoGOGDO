<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiController extends Controller
{
    public function preguntar(Request $request)
    {
        // Validar entrada
        $request->validate([
            'pregunta' => 'required|string|max:2000'
        ]);

        $pregunta = $request->input('pregunta');
        $apiKey = env('GEMINI_API_KEY');

        if (!$apiKey) {
            return response()->json([
                'error' => ['message' => 'Falta configurar GEMINI_API_KEY en el .env']
            ], 500);
        }

        // ✅ ENDPOINT CORRECTO ACTUAL (v1 + modelo vigente)
        $url = "https://generativelanguage.googleapis.com/v1/models/gemini-1.5-flash-latest:generateContent?key=" . $apiKey;

        try {

            $response = Http::timeout(60)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post($url, [
                    "contents" => [
                        [
                            "role" => "user",
                            "parts" => [
                                [
                                    "text" => 
"Actúa como un asistente docente llamado Asistente GDO. 
Eres amable, claro y ayudas a profesores con dudas académicas, grupos y calificaciones.

Pregunta del profesor:
" . $pregunta
                                ]
                            ]
                        ]
                    ],

                    // 🔥 Configuración recomendada
                    "generationConfig" => [
                        "temperature" => 0.7,
                        "topK" => 40,
                        "topP" => 0.95,
                        "maxOutputTokens" => 1024,
                    ]
                ]);

            $data = $response->json();

            // Log para depuración si algo falla
            Log::info("Respuesta Gemini:", $data ?? []);

            // Si la petición fue exitosa
            if ($response->successful()) {
                return response()->json($data);
            }

            // Si Google devuelve error, lo reenviamos al frontend
            return response()->json([
                'error' => [
                    'message' => $data['error']['message'] ?? 'Error desconocido de Google'
                ]
            ], $response->status());

        } catch (\Exception $e) {

            Log::error("Error Gemini: " . $e->getMessage());

            return response()->json([
                'error' => ['message' => 'Error de conexión con Gemini']
            ], 500);
        }
    }
}