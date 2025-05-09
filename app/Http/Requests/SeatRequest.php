<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SeatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'busId' => 'required|exists:buses,busId',
            'seatNumber' => [
                'required',
                'string',
                Rule::unique('seats')->where('busId', $this->busId)->ignore($this->seatId, 'seatId')
            ],
            'isAvailable' => 'sometimes|boolean',
        ];
    }
}
