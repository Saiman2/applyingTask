<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;


class AddEditRepairRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(Request $request)
    {

        $rules = [
            'name' => 'required|min:2|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required',
            'brand' => 'required',
            'model' => 'required',
            'year' => 'required',
            'time_to_complete' => 'required',
            'probable_problem' => 'required',
            'employees_required_info' => 'required',
        ];
        if (!$request->user_id) {
            $rules['password'] = 'min:6|confirmed';
        }
        return $rules;
    }

}
