<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RouteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // allow all (adjust if you need admin-only)
    }

    public function rules(): array
    {
        return [
            'departure' => 'required|string|max:100',
            'destination' => 'required|string|max:100',
            'departureDate' => 'required|date',
            'departureTime' => [
                'required',
                'regex:/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/' // HH:MM format
            ],
            'availableSeats' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'departureTime.regex' => 'The departure time must be in HH:MM format (24-hour).',
        ];
    }
}
