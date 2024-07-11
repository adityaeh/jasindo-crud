<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // $codeRules = "required|string|max:255|unique:m_cycle_capacities";

        // if ($this->isMethod('put')) {
        //     $codeRules = "required|string|max:255|unique:m_cycle_capacities,code,$this->id";
        // }

        $rules = [
            'email' => 'required|email',
            'name' => 'required|min:6'
        ];
        if ($this->isMethod('post')) {
            $rules = array_merge(['password' => "required|string|min:8"], $rules);
        }
        return $rules;
    }

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
     * Return Custom Attribute For Custom Message
     *
     * @return array
     */
    public function attributes()
    {
        $attributes = [
            'email' => 'Email',
            'name' => 'Name',
        ];

        if ($this->isMethod('post')) {
            $attributes = array_merge(['password' => "Password"], $attributes);
        }
        return $attributes;
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'message' => 'Bad Request',
            'code' => 400,
            'errors' => $validator->errors()
        ], 400);
        throw new HttpResponseException($response);
    }
}
