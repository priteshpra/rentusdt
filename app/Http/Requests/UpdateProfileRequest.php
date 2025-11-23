<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Auth;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        $userId = Auth::id();

        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($userId),
            ],
            // contact rules (recommended international)
            'contact' => ['nullable', 'regex:/^\+?[0-9]{10,10}$/'],

            // avatar: optional image
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // max 2MB

            // password optional; confirm only when provided
            'password' => 'nullable|string|min:6|confirmed',
            'wallet_address' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'contact.regex' => 'Please enter a valid contact number (10-15 digits, optional leading +).',
        ];
    }
}
