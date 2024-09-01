<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentOrderRequest extends FormRequest
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
                'input-order_creation_date' => 'required',
                'input-payment_date' => 'required',
                'input-payment_amount' => 'required|min:1|max:50',
                'input-currency' => 'required',
                'input-status' => 'required',
            ],
            "PUT" => [
                'input-order_creation_date' => 'required',
                'input-payment_date' => 'required',
                'input-payment_amount' => 'required|min:1|max:50',
                'input-currency' => 'required',
                'input-status' => 'required',
            ],
            default => [],
        };
    }

    public function attributes()
    {
        return [
            'input-client_id' => __('messages.payment_orders.form.01'),
            'input-order_creation_date' => __('messages.payment_orders.form.02'),
            'input-payment_date' => __('messages.payment_orders.form.03'),
            'input-payment_amount' =>  __('messages.payment_orders.form.04'),
            'input-currency' =>  __('messages.payment_orders.form.05'),
            'input-status' =>  __('messages.payment_orders.form.06')
        ];
    }
}
