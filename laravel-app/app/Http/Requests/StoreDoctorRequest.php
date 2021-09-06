<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
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
            'name_arabic' => 'required|min:3|max:150',
            'name_english' => 'required|min:3|max:150',
            'password' => 'required',
            'mobile' => 'required|numeric|unique:doctors,mobile,NULL,id,deleted_at,NULL',
            'photo' => 'required|mimes:jpeg,jpg,png|max:2048',
            'time_slot' => 'required|numeric',
            'email' => 'required|email',
            'services' => 'required|array',
            'services.*.service_id' => 'required|distinct|exists:services,id',
            'doctor_week_days' => 'required|array',
            'doctor_week_days.*.week_day_id' => 'required|distinct|exists:week_days,id',
            'doctor_week_days.*.start_hour' => 'required|date_format:H:i',
            'doctor_week_days.*.to_hour' => 'required|date_format:H:i|after:doctor_week_days.*.start_hour'
        ];
    }
}
