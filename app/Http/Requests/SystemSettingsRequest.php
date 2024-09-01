<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SystemSettingsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'input-system_currency' => 'required',
            'input-auto_suspend_days' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'input-system_currency' => __('messages.system_settings.form.01'),
            'input-auto_suspend_days' => __('messages.system_settings.form.02'),
            'input-whatsapp_contact' => __('messages.system_settings.form.03'),
            'input-telegram_contact' => __('messages.system_settings.form.04'),
            'input-skype_contact' => __('messages.system_settings.form.05')
        ];
    }

}
