<?php

namespace App\Services;

use App\Repositories\TrainRepository;
use Illuminate\Support\Carbon;

class TrainService
{
    private $trainRepository;

    public function __construct(TrainRepository $trainRepository)
    {
        $this->trainRepository = $trainRepository;
    }

    /**
     * Fetch and return data for the dashboard including stations, arrivals, and departures.
     *
     * @param array $params Parameters to filter arrivals and departures.
     * @return array An array containing all the required data for the dashboard.
     */
    public function getDashboardData(array $params)
    {
        try {
            // Fetch arrivals and departures only if a specific station is provided.
            if (!empty($params['station'])) {
                return [
                    'arrivals' => $this->filterByComingHour($this->trainRepository->getArrivals($params)),
                    'departures' => $this->filterByComingHour($this->trainRepository->getDepartures($params)),
                ];
            }

            return [
                'arrivals' => [],
                'departures' => []
            ];
        } catch (\Exception $e) {
            \Log::error('Error in service layer: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Fetch the list of stations.
     * This method is separate because it is called regardless of whether a station is selected.
     *
     * @return array An array of station data.
     */
    public function getStations()
    {
        try {
            return $this->trainRepository->getStations();
        } catch (\Exception $e) {
            \Log::error('Error fetching stations: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Filter the data to only include records for the coming hour.
     *
     * @param array $data Array of arrival or departure data.
     * @return array Filtered data.
     */
    private function filterByComingHour(array $data)
    {
        return array_filter($data, function ($entry) {
            $plannedDateTime = Carbon::parse($entry['plannedDateTime']);
            $now = Carbon::now();
            return $plannedDateTime->isBetween($now, $now->copy()->addHour());
        });
    }
}
