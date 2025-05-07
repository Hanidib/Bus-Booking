<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // or add admin-only logic
    }

    public function rules(): array
    {
        return [
            'busId' => 'required|exists:buses,busId',
            'seatNumber' => 'required|string|unique:seats,seatNumber',
            'isAvailable' => 'boolean',
        ];
    }
}
