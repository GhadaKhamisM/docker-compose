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
            'en' => 'required',
            'en.name' => 'required|min:3|max:150|unique:service_translations,name,'.$this->service->id.',service_id,deleted_at,NULL',
            'en.description' => 'sometimes|min:3|max:300',
            'ar' => 'required',
            'ar.name' => 'required|min:3|max:150|unique:service_translations,name,'.$this->service->id.',service_id,deleted_at,NULL',
            'ar.description' => 'sometimes|min:3|max:300',
        ];
    }
}
