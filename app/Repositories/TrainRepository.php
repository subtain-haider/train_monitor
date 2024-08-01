<?php

namespace App\Repositories;

use App\Contracts\TrainRepositoryContract;
use App\Traits\NsApi;
use App\Traits\HandleCache;
use App\Traits\GeoLocation;
use Illuminate\Support\Carbon;

class TrainRepository implements TrainRepositoryContract
{
    use NsApi, HandleCache, GeoLocation;

    public function getArrivals($params)
    {
        return $this->fetchData($params['station'], 'arrivals');
    }

    public function getDepartures($params)
    {
        return $this->fetchData($params['station'], 'departures');
    }

    public function getStations()
    {
        $cacheKey = $this->getCacheKey('', 'stations');
        try {
            if ($this->hasCache($cacheKey)) {
                return $this->getCache($cacheKey);
            }
            $data = $this->getDataFromApi('stations', []);
            $this->setCache($cacheKey, $data, 60); // Cache data for 60 minutes
            return $data['payload'];
        } catch (\Exception $e) {
            $this->clearCache($cacheKey); // Clear cache on error
            throw $e;
        }
    }

    private function fetchData($station, $type)
    {
        $cacheKey = $this->getCacheKey($station, $type);
        try {
            if ($this->hasCache($cacheKey)) {
                return $this->getCache($cacheKey);
            }
            $data = $this->getDataFromApi($type, ['station' => $station]);
            $filteredData = $this->filterDataByComingHour($data['payload'][$type]);
            $this->setCache($cacheKey, $filteredData, 60);
            return $filteredData;
        } catch (\Exception $e) {
            $this->clearCache($cacheKey); // Clear cache on error
            throw $e;
        }
    }

    private function getCacheKey($station, $type)
    {
        return "train_data_{$type}_{$station}";
    }

    private function filterDataByComingHour(array $data)
    {
        $now = Carbon::now();
        return array_filter($data, function ($item) use ($now) {
            $plannedDateTime = Carbon::parse($item['plannedDateTime']);
            return $plannedDateTime->isBetween($now, $now->copy()->addHour());
        });
    }
}
