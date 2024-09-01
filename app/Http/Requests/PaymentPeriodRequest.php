<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentPeriodRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return match ($this->getMethod()) {
            "POST" => [
                'input-client_id' => 'required',
                'input-payment_start_date' => 'required',
                'input-payment_amount' => 'required|min:2|max:50',
                'input-currency' => 'required',
                'input-show_delayed_payment_warnings' => 'required',
            ],
            "PUT" => [
                'input-payment_start_date' => 'required',
                'input-payment_amount' => 'required|min:2|max:50',
                'input-currency' => 'required',
                'input-show_delayed_payment_warnings' => 'required',
            ],
            default => [],
        };
    }

    public function attributes()
    {
        return [
            'input-client_id' => __('messages.payment_periods.form.01'),
            'input-payment_start_date' => __('messages.payment_periods.form.02'),
            'input-payment_amount' => __('messages.payment_periods.form.03'),
            'input-currency' =>  __('messages.payment_periods.form.04'),
            'input-show_delayed_payment_warnings' =>  __('messages.payment_periods.form.05')
        ];
    }
}
