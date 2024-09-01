<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return match ($this->getMethod()) {
            "POST" => [
                'input-first_name' => 'required|min:2|max:50',
                'input-last_name' => 'required|min:2|max:50',
                'input-email' => 'required|email|min:5|max:50|unique:.users,email',
                'input-company_name' => 'required|min:2|max:150',
                'input-contact_no' => 'required|min:2|max:200',
                'input-address' => 'required|min:2|max:200',
                'input-is_active' => 'required',
            ],
            "PUT" => [
                'input-first_name' => 'required|min:2|max:50',
                'input-last_name' => 'required|min:2|max:50',
                'input-company_name' => 'required|min:2|max:150',
                'input-contact_no' => 'required|min:2|max:200',
                'input-address' => 'required|min:2|max:200',
                'input-is_active' => 'required'
            ],
            default => [],
        };
    }

    public function attributes()
    {
        return [
            'input-first_name' => __('messages.users.form.01'),
            'input-last_name' => __('messages.users.form.02'),
            'input-email' => __('messages.users.form.03'),
            'input-company_name' => __('messages.clients.form.01'),
            'input-contact_no' => __('messages.clients.form.02'),
            'input-address' => __('messages.clients.form.03'),
            'input-is_active' => __('messages.clients.form.04'),
        ];
    }
}
