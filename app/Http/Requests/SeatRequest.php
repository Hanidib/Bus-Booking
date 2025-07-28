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
        $seatId = $this->route('seat') ? $this->route('seat')->seatId : null;

        return [
            'busId' => 'required|exists:buses,busId',
            'seatNumber' => [
                'required',
                'string',
                'max:10',
                Rule::unique('seats')->where(function ($query) {
                    return $query->where('busId', $this->busId);
                })->ignore($seatId, 'seatId'),
            ],
            'isAvailable' => 'required|boolean',
        ];
    }
}
