<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArrivalDepartureGetRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'station' => 'nullable|string',
            'arrival_page' => 'nullable|integer',
            'departure_page' => 'nullable|integer'
        ];
    }
}
