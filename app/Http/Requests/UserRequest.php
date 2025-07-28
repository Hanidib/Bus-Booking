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
            // For new user creation
            $rules['email'] = 'required|email|unique:users,email';
            $rules['password'] = 'required|string|min:6|confirmed';
        } else {
            // For user updates
            $userId = $this->route('id') ?? $this->userId;
            $rules['email'] = 'required|email|unique:users,email,' . $userId . ',userId';
            $rules['password'] = 'nullable|string|min:6|confirmed';
        }

        return $rules;
    }
}
