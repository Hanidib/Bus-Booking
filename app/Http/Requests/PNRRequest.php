<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PnrRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'bookingId' => 'required|exists:bookings,bookingId',
            'pnrCode' => 'required|unique:pnrs,pnrCode',

        ];
    }
}
