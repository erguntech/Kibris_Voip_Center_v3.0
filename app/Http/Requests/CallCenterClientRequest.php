<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CallCenterClientRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return match ($this->getMethod()) {
            "POST" => [
                'input-assigned_user_id' => 'required',
                'input-first_name' => 'required|min:2|max:150',
                'input-last_name' => 'required|min:2|max:150',
                'input-company_name' => 'sometimes|min:2|max:150',
                'input-contact_no' => 'required|min:2|max:50',
                'input-description' => 'sometimes|min:0|max:500',
                'input-is_active' => 'required',
            ],
            "PUT" => [
                'input-assigned_user_id' => 'required',
                'input-first_name' => 'required|min:2|max:150',
                'input-last_name' => 'required|min:2|max:150',
                'input-company_name' => 'sometimes|min:2|max:150',
                'input-contact_no' => 'required|min:2|max:50',
                'input-description' => 'sometimes|min:0|max:500',
                'input-is_active' => 'required'
            ],
            default => [],
        };
    }
    public function attributes()
    {
        return [
            'input-assigned_user_id' => __('messages.call_center_clients.form.01'),
            'input-first_name' => __('messages.call_center_clients.form.02'),
            'input-last_name' => __('messages.call_center_clients.form.03'),
            'input-company_name' => __('messages.call_center_clients.form.04'),
            'input-contact_no' => __('messages.call_center_clients.form.05'),
            'input-description' => __('messages.call_center_clients.form.06'),
            'input-status' => __('messages.call_center_clients.form.07'),
            'input-is_active' => __('messages.call_center_clients.form.08'),
        ];
    }
}
