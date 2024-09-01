<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceFeeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return match ($this->getMethod()) {
            "PUT" => [
                'input-sms_service_fee' => 'required|min:1|max:50'
            ],
            default => [],
        };
    }

    public function attributes()
    {
        return [
            'input-sms_service_fee' => __('messages.service_fees.form.01')
        ];
    }
}
