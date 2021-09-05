<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientLoginRequest extends FormRequest
{
    /**
     * Determine if the patient is authorized to make this request.
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
            'mobile' => 'required|numeric',
            'password' => 'required',
        ];
    }
}
