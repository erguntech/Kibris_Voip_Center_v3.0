<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceFeeRequest;
use Illuminate\Http\Request;

class ServiceFeeController extends Controller
{
    public function index()
    {
        return view('pages.service_fees.service_fees_index');
    }

    public function serviceFeesUpdate(ServiceFeeRequest $request)
    {
        settings()->set([
            'app_sms_service_fee' => $request['input-sms_service_fee']
        ]);

        return redirect()->route('ServiceFees.Index')
            ->with('result','warning')
            ->with('title',__('messages.alerts.01'))
            ->with('content',__('messages.alerts.04'));
    }
}
