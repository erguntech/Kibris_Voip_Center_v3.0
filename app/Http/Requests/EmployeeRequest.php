<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
                'input-extension_no' => 'required',
                'input-show_numbers' => 'required',
                'input-is_active' => 'required',
            ],
            "PUT" => [
                'input-first_name' => 'required|min:2|max:50',
                'input-last_name' => 'required|min:2|max:50',
                'input-extension_no' => 'required',
                'input-show_numbers' => 'required',
                'input-is_active' => 'required',
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
            'input-is_active' => __('messages.users.form.05'),
            'input-show_numbers' => __('messages.employees.form.03'),
            'input-extension_no' =>  __('messages.employees.form.01')
        ];
    }
}
