<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|min:2|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required',
            'password' => 'required|min:6|confirmed',
        ];

        return $rules;
    }

}
