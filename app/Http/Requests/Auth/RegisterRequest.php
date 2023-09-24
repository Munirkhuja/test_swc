<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => ['required', 'string', 'max:200', 'alpha_dash'],
            'password' => ['required', 'string', 'confirmed'],
            'first_name' => ['required', 'string', 'max:200', 'alpha'],
            'last_name' => ['required', 'string', 'max:200', 'alpha'],
            'birthday' => ['nullable', 'date_format:Y-m-d', 'before:tomorrow', 'after:1800-01-01'],
        ];
    }
}
