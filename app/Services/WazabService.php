<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WazabService
{
    public static function sendMessage(string $phone, string $message)
    {
        $apiUrl = env('WATZAP_API_URL');
        $apiKey = env('WATZAP_API_KEY');

        return Http::withHeaders([
            'Authorization' => "Bearer {$apiKey}",
        ])->post("{$apiUrl}/send-message", [
            'phone'   => $phone,
            'message' => $message,
        ]);
    }
}
