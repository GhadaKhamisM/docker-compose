<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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
            'service_translations' => 'required|array',
            'service_translations.*.name' => 'required|min:3|max:150|unique:service_translations,name,NULL,id,deleted_at,NULL',
            'service_translations.*.description' => 'sometimes|min:3|max:300',
            'service_translations.*.locale' => 'required|distinct'
        ];
    }
}
