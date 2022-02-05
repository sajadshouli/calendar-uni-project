<?php

namespace App\Http\Requests\Api\Auth;

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
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => [
                'required',
                'max:255'
            ],
            'last_name' => [
                'required',
                'max:255'
            ],
            'mobile' => [
                'required',
                'numeric',
                'digits:11',
                'unique:users,mobile',
                'regex:/^09[0-9]{9}$/'
            ],
            'password' => [
                'required',
                'min:6',
                'confirmed'
            ]
        ];
    }
}
