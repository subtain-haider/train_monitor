<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArrivalDepartureGetRequest;
use App\Services\TrainService;
use Illuminate\Support\Facades\Log;

class TrainController extends Controller
{
    private $trainService;

    public function __construct(TrainService $trainService)
    {
        $this->trainService = $trainService;
    }

    public function index(ArrivalDepartureGetRequest $request)
    {
        $data = [
            'stations' => $this->trainService->getStations(),
            'arrivals' => [],
            'departures' => [],
            'selected_station' => $request->get('station')
        ];

        if ($request->filled('station')) {
            try {
                $dashboardData = $this->trainService->getDashboardData($request->validated());
                $data = array_merge($data, $dashboardData);
            } catch (\Exception $e) {
                Log::error('Failed to fetch train data: ' . $e->getMessage());
                $data['error'] = 'Failed to load train data: ' . $e->getMessage();
            }
        }
        return view('index', $data);
    }
}
