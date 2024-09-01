<?php

namespace App\Http\Controllers;

use Akaunting\Money\Money;
use App\Models\Client;
use App\Models\ClientModule;
use App\Models\PaymentOrder;
use App\Models\SMSCreditLog;
use App\Models\SMSDevice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Yajra\DataTables\DataTables;
use QCod\Settings\Setting\Setting;

class SMSCreditController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Sistem Yöneticisi|Sistem Kullanıcısı'],['only' => ['index', 'assignCreditsToClient', 'assignCreditsToDevice']]);
    }

    public function index(Request $request)
    {
        $smsServiceFee = "".Money::TRY(settings()->get("app_sms_service_fee"), true);

        $clients = Client::all();
        $clientsSMSActive = new Collection();

        foreach ($clients as $client) {
            if ($client->linkedClientModules->sms_module == true) {
                $clientsSMSActive->add($client);
            }
        }

        $SMSCreditLogs = SMSCreditLog::where('credit_type', 2)->get();

        if ($request->ajax()) {
            return Datatables::of($SMSCreditLogs)
                ->addIndexColumn()
                ->addColumn('companyName', function ($row_companyName) {
                    $client = Client::find($row_companyName->client_id);
                    return $client->company_name;
                })
                ->addColumn('SMSDeviceName', function ($row_SMSDeviceName) {
                    return $row_SMSDeviceName->linkedDevice->device_name;
                })
                ->addColumn('oldCredits', function ($row_oldCredits) {
                    return '<span class="badge rounded-pill badge-light-warning">'.$row_oldCredits->owned_credits.'</span>';
                })
                ->addColumn('creditsAdd', function ($row_creditsAdd) {
                    return '<span class="badge rounded-pill badge-light-info">'.$row_creditsAdd->credit_to_add.'</span>';
                })
                ->addColumn('totalCredits', function ($row_totalCredits) {
                    return '<span class="badge rounded-pill badge-light-success">'.$row_totalCredits->credits_summary.'</span>';
                })
                ->rawColumns(['oldCredits', 'creditsAdd', 'totalCredits'])
                ->make(true);
        }

        return view('pages.sms_credits.sms_credits_index', compact('clientsSMSActive', 'smsServiceFee'));
    }

    public function assignCreditsToClient(Request $request)
    {
        $client = Client::find($request['clientID']);
        $clientModule = ClientModule::where('client_id', $client->id)->first();
        $oldCredits = $clientModule->sms_credits;
        $clientModule->sms_credits += $request['creditsToAdd'];
        $clientModule->save();

        $SMSCreditLog = new SMSCreditLog();
        $SMSCreditLog->credit_type = 2;
        $SMSCreditLog->client_id = $client->id;
        $SMSCreditLog->device_id = $clientModule->sms_module_device_id;
        $SMSCreditLog->owned_credits = $oldCredits;
        $SMSCreditLog->credit_to_add = $request['creditsToAdd'];
        $SMSCreditLog->credits_summary = $clientModule->sms_credits;

        $paymentOrder = new PaymentOrder();
        $paymentOrder->client_id = $client->id;
        $paymentOrder->order_creation_date = Carbon::now();
        $paymentOrder->payment_date = Carbon::now();
        $paymentOrder->payment_amount = floatval($request['creditsToAdd']) * settings()->get("app_sms_service_fee", $default = null);;
        $paymentOrder->currency = "TRY";
        $paymentOrder->status = 1;
        $paymentOrder->invoice_type = 2;
        $paymentOrder->save();

        $SMSCreditLog->payment_order_id = $paymentOrder->id;
        $SMSCreditLog->save();

        return response()->json([
            'status' => 'success',
            'title' => __('messages.alerts.01'),
            'message' => __('messages.alerts.03'),
            'oldCredits' => $oldCredits,
            'creditsX' => $request['creditsToAdd'],
            'totalCredits' => $clientModule->sms_credits,
        ]);
    }

    public function assignCreditsToDevice(Request $request)
    {
        $SMSDevice = SMSDevice::find($request['deviceID']);
        $oldCredits = $SMSDevice->credit_count;
        $SMSDevice->credit_count += $request['creditsToAdd'];
        $SMSDevice->save();

        $SMSCreditLog = new SMSCreditLog();
        $SMSCreditLog->credit_type = 1;
        $SMSCreditLog->client_id = null;
        $SMSCreditLog->device_id = $request['deviceID'];
        $SMSCreditLog->owned_credits = $oldCredits;
        $SMSCreditLog->credit_to_add = $request['creditsToAdd'];
        $SMSCreditLog->credits_summary = $SMSDevice->credit_count;
        $SMSCreditLog->save();

        return response()->json([
            'device' => $SMSDevice,
            'device_id' => $request['deviceID'],
            'status' => 'success',
            'title' => __('messages.alerts.01'),
            'message' => __('messages.alerts.03'),
            'oldCredits' => $oldCredits,
            'creditsToAdd' => $request['creditsToAdd'],
            'totalCredits' => $SMSDevice->credit_count,
        ]);
    }
}
