<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('admins', 'email')->ignore($this->admin?->adminId, 'adminId')
            ],
            'password' => $this->isMethod('POST') ? 'required|string|min:8' : 'sometimes|string|min:8',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The admin name is required',
            'email.unique' => 'This email is already registered',
            'password.min' => 'Password must be at least 8 characters',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->email) {
            $this->merge(['email' => strtolower($this->email)]);
        }
    }
}
