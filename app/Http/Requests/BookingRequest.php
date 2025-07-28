<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'userId' => 'required|exists:users,userId',
            'seatId' => 'required|exists:seats,seatId',
            'routeId' => 'required|exists:routes,routeId',
            'bookingDate' => 'required|date',
            'status' => 'required|string',
        ];
    }
}
