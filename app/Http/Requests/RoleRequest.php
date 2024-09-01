<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
                    'input-name' => 'required|min:2|max:50|unique:roles,name',
                    'input-description' => 'required|min:2|max:200',
                ];
            case "PUT":
                return [
                    'input-name' => 'required|min:2|max:50|unique:roles,name,'.$this->role,
                    'input-description' => 'required|min:2|max:200',
                ];
            default:
                return [];
        }
    }

    public function attributes()
    {
        return [
            'input-name' => __('messages.roles.form.01'),
            'input-description' => __('messages.roles.form.02'),
        ];
    }
}
