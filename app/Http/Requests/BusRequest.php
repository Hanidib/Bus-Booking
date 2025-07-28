<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Get the current bus ID if we're updating
        $busId = $this->route('bus') ? $this->route('bus')->busId : null;

        return [
            'busNumber' => 'required|string|max:50|unique:buses,busNumber,' . $busId . ',busId',
            'busType' => 'required|string|max:50',
            'totalSeats' => 'required|integer|min:1',
            'routeId' => 'required|exists:routes,routeId',
        ];
    }

    public function messages(): array
    {
        return [
            'busNumber.required' => 'The bus number is required.',
            'busNumber.string' => 'The bus number must be a string.',
            'busNumber.max' => 'The bus number may not be greater than 50 characters.',
            'busNumber.unique' => 'The bus number has already been taken.',
            'busType.required' => 'The bus type is required.',
            'busType.string' => 'The bus type must be a string.',
            'busType.max' => 'The bus type may not be greater than 50 characters.',
            'totalSeats.required' => 'The total seats are required.',
            'totalSeats.integer' => 'The total seats must be an integer.',
            'totalSeats.min' => 'The total seats must be at least 1.',
            'routeId.required' => 'The route ID is required.',
            'routeId.exists' => 'The selected route does not exist.',
        ];
    }
}
