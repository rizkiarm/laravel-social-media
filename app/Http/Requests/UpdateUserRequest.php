<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'username' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['confirmed'],
            'password_confirmation' => [],
            'photo' => ['mimes:jpg,bmp,png,gif', 'max:5048'],
            'description' => [],
            'gender' => ['in:male,female'],
            'birthdate' => ['date'],
            'location' => [],
            'private' => ['boolean'],
        ];
    }
}
