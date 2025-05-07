<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'rank' => 'nullable|string|max:255',
            'militaryId' => 'nullable|integer',
            'phoneNumber' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ];

        if ($this->isMethod('post')) {
            $rules['email'] = 'required|email|unique:users,email';
            $rules['password'] = 'required|string|min:6|confirmed';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['email'] = 'required|email|unique:users,email,' . $this->userId . ',userId';
            $rules['password'] = 'nullable|string|min:6|confirmed';
        }

        return $rules;
    }
}
