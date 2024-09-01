<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        switch ($this->getMethod()) {
            case "POST":
                return [
                    'input-first_name' => 'required|min:2|max:50',
                    'input-last_name' => 'required|min:2|max:50',
                    'input-email' => 'required|email|min:5|max:50|unique:.users,email',
                    'input-client_id' => 'required',
                    'input-user_type' => 'required',
                    'input-is_active' => 'required',
                ];
            case "PUT":
                return [
                    'input-first_name' => 'required|min:2|max:50',
                    'input-last_name' => 'required|min:2|max:50',
                    'input-client_id' => 'required',
                    'input-user_type' => 'required',
                    'input-is_active' => 'required',
                ];
            default:
                return [];
        }
    }

    public function attributes()
    {
        return [
            'input-first_name' => __('messages.users.form.01'),
            'input-last_name' => __('messages.users.form.02'),
            'input-email' => __('messages.users.form.03'),
            'input-client_id' => __('messages.users.form.04'),
            'input-user_type' => __('messages.users.form.07'),
            'input-is_active' => __('messages.users.form.05'),
        ];
    }
}
