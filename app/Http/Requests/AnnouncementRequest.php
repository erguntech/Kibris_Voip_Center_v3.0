<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnnouncementRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return match ($this->getMethod()) {
            "POST" => [
                'input-announcement_content' => 'required|min:2|max:150',
                'input-is_active' => 'required',
            ],
            "PUT" => [
                'input-announcement_content' => 'required|min:2|max:150',
                'input-is_active' => 'required'
            ],
            default => [],
        };
    }

    public function attributes()
    {
        return [
            'input-announcement_content' => __('messages.announcements.form.01'),
            'input-is_active' => __('messages.announcements.form.04')
        ];
    }
}
