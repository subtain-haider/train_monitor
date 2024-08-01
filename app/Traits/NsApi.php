<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait NsApi
{
    protected function getDataFromApi($endpoint, $payload)
    {
        $apiKey = config('services.ns_api.key');
        $baseUrl = config('services.ns_api.url') . '/' . $endpoint;
        try {
            $response = Http::withHeaders([
                'Ocp-Apim-Subscription-Key' => $apiKey,
            ])->get($baseUrl, $payload);

            if ($response->successful()) {
                return $response->json();
            }

            throw new \Exception("API call failed: " . $response->body());
        } catch (\Exception $e) {
            \Log::error('API Call Error: ' . $e->getMessage());
            throw $e;
        }
    }
}
