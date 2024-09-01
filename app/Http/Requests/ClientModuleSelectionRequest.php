<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientModuleSelectionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return match ($this->getMethod()) {
            "POST" => [
                'input-sms_module' => 'required',
                'input-sms_module_device_id' => 'required_if:input-sms_module,1',
                'input-pbx_module' => 'required',
                'input-pbx_server_ip_address' => 'required_if:input-pbx_module,1',
            ],
            "PUT" => [
                'input-sms_module' => 'required',
                'input-sms_module_device_id' => 'required_if:input-sms_module,1',
                'input-pbx_module' => 'required',
                'input-pbx_server_ip_address' => 'required_if:input-pbx_module,1'
            ],
            default => [],
        };
    }

    public function attributes()
    {
        return [
            'input-pbx_module' => __('messages.client_module_selection.form.01'),
            'input-pbx_server_ip_address' => __('messages.client_module_selection.form.02'),
            'input-sms_module' => __('messages.client_module_selection.form.03'),
            'input-sms_module_device_id' => __('messages.client_module_selection.form.04'),
        ];
    }
}
