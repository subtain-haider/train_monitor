<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait GeoLocation
{
    /**
     * Fetch the nearest station based on user's IP geolocation.
     * 
     * @return string|void Nearest station name or nothing on failure.
     */
    protected function getNearestStation()
    {
        $geoData = $this->getGeoLocation();
        if (!$geoData) {
            return;
        }

        $lat = $geoData['lat'];
        $lng = $geoData['lon'];

        return $this->fetchNearestStation($lat, $lng);
    }

    /**
     * Get geolocation data based on user's IP.
     * 
     * @return array|null Geolocation data or null on failure.
     */
    protected function getGeoLocation()
    {
        $userIP = $this->getUserIP();
        $geoApiUrl = config('services.geolocation.url');

        try {
            $response = Http::get("{$geoApiUrl}/json/{$userIP}");
            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {
            \Log::error('Geolocation error: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Fetch the nearest NS station based on latitude and longitude.
     * 
     * @param float $lat Latitude.
     * @param float $lng Longitude.
     * @return string|null The name of the nearest station or null on failure.
     */
    protected function fetchNearestStation($lat, $lng)
    {
        $apiUrl = config('services.ns_api.url') . '/nsapp-stations/v2/nearest';
        $apiKey = config('services.ns_api.key');

        try {
            $response = Http::withHeaders([
                'Ocp-Apim-Subscription-Key' => $apiKey
            ])->get($apiUrl, [
                'lat' => $lat,
                'lng' => $lng,
                'limit' => 1
            ]);

            if ($response->successful()) {
                $stations = $response->json();
                dd($stations );
                if (!empty($stations)) {
                    return $stations[0]['namen']['lang'];
                }
            }
        } catch (\Exception $e) {
            \Log::error('NS API error: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Get user's IP address.
     * 
     * @return string User IP address.
     */
    protected function getUserIP()
    {
        return request()->ip(); 
    }
}
