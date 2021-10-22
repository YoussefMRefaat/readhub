<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required' , 'string' , 'min:4'],
            'email' => ['required' , 'email' , 'unique:users'],
            'password' => ['required' , 'string' , 'confirmed' , 'min:6'],
            'avatar' => ['image' , 'max:512'],
        ];
    }
}
