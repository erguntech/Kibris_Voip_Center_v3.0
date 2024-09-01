<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GeneralSettingsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'input-auto_logout_duration' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'input-auto_logout_duration' => __('messages.general_settings.form.01')
        ];
    }
}
