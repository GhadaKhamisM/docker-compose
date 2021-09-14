<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
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
            'doctor_id' => 'required|exists:doctors,id,deleted_at,NULL',
            'doctor_week_day_id' => 'required|exists:doctor_week_days,id,doctor_id,'.$this->doctor_id.',deleted_at,NULL',
            'visit_date' => 'required|date|after_or_equal:today|date_format:Y-m-d',
            'start_hour' => 'required|date_format:H:i',
            'to_hour' => 'required|date_format:H:i|after:start_hour'
        ];
    }
}
