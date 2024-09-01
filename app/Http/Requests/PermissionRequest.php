<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
                    'input-name' => 'required|min:2|max:50|unique:permissions,name',
                    'input-description' => 'required|min:2|max:200',
                    'input-role_selection' => 'required',
                ];
            case "PUT":
                return [
                    'input-name' => 'required|min:2|max:50|unique:roles,name,'.$this->permission,
                    'input-description' => 'required|min:2|max:200',
                    'input-role_selection' => 'required',
                ];
            default:
                return [];
        }
    }

    public function attributes()
    {
        return [
            'input-name' => __('messages.permissions.form.01'),
            'input-description' => __('messages.permissions.form.02'),
            'input-role_selection' => __('messages.permissions.form.03'),
        ];
    }
}
