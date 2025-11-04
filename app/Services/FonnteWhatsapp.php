<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteWhatsApp
{
    public static function send(string $phone, string $message): bool
    {
        $token = config('services.fonnte.token');
        if (!$token) {
            Log::warning('[Fonnte] token kosong. Pastikan FONNTE_TOKEN ada di .env dan config/services.php.');
            return false;
        }

        $target = self::normalizeIndoPhone($phone);
        if (!$target) {
            Log::warning('[Fonnte] nomor tidak valid', ['raw' => $phone]);
            return false;
        }

        $payload = [
            'target'  => $target,           // 62xxxxxxxxxx
            'message' => $message,
            // 'countryCode' => '62',        // opsional; biasanya tak perlu kalau target sudah 62...
            // 'delay'       => 0,           // opsional
            // 'schedule'    => 0,           // opsional
            // 'typing'      => false,       // opsional
        ];

        $resp = Http::withHeaders(['Authorization' => $token])
            ->asForm()
            ->post('https://api.fonnte.com/send', $payload);

        // --- DEBUG LOG ---
        Log::info('[Fonnte] response', [
            'status' => $resp->status(),
            'body'   => $resp->body(),
        ]);

        if (!$resp->ok()) {
            return false;
        }

        // Fonnte biasanya balas JSON: { "status": true/false, "id": "...", "detail": "...", ... }
        $json = $resp->json();
        $success = (is_array($json) && (isset($json['status']) ? (bool)$json['status'] : false));

        if (!$success) {
            Log::warning('[Fonnte] API mengembalikan status=false', ['json' => $json, 'payload' => $payload]);
        }

        return $success;
    }

    private static function normalizeIndoPhone(string $raw): ?string
    {
        $digits = preg_replace('/\D+/', '', $raw ?? '');
        if (!$digits) return null;

        if (str_starts_with($digits, '62')) return $digits;
        if (str_starts_with($digits, '0'))  return '62' . substr($digits, 1);
        if (str_starts_with($digits, '8'))  return '62' . $digits;

        return $digits; // fallback
    }
}
