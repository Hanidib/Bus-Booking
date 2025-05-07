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
            'departure' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departureDate' => 'required|date',
            'departureTime' => 'required|date_format:H:i:s',
        ];
    }
}
