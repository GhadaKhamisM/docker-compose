<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
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
            'name_arabic' => 'required|min:3|max:150|unique:services,name_arabic,'.$this->service->id.',id,deleted_at,NULL',
            'name_english' => 'required|min:3|max:150|unique:services,name_english,'.$this->service->id.',id,deleted_at,NULL',
            'description' => 'sometimes|min:3|max:300',
        ];
    }
}
