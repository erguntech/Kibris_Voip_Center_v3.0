<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SMSDeviceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return match ($this->getMethod()) {
            "POST" => [
                'input-device_name' => 'required|min:1|max:50',
                'input-phone_no' => 'required|min:1|max:50',
                'input-gsm_api_token' => 'required|min:1|max:500',
                'input-credit_count' => 'required|min:1|max:50',
                'input-is_active' => 'required',
            ],
            "PUT" => [
                'input-device_name' => 'required|min:1|max:50',
                'input-phone_no' => 'required|min:1|max:50',
                'input-gsm_api_token' => 'required|min:1|max:500',
                'input-credit_count' => 'required|min:1|max:50',
                'input-is_active' => 'required'
            ],
            default => [],
        };
    }

    public function attributes()
    {
        return [
            'input-device_name' => __('messages.sms_devices.form.01'),
            'input-phone_no' => __('messages.sms_devices.form.02'),
            'input-gsm_api_token' => __('messages.sms_devices.form.03'),
            'input-assigned_client_id' =>  __('messages.sms_devices.form.04'),
            'input-credit_count' =>  __('messages.sms_devices.form.05'),
            'input-is_active' =>  __('messages.sms_devices.form.06')
        ];
    }
}
