<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentPeriodRequest;
use App\Models\Client;
use App\Models\PaymentOrder;
use App\Models\PaymentPeriod;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use QCod\Settings\Setting\Setting;
use Akaunting\Money\Currency;
use Akaunting\Money\Money;

class PaymentPeriodController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Sistem Yöneticisi|Sistem Kullanıcısı'],['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy']]);
    }

    public function index(Request $request)
    {
        $data = PaymentPeriod::all();
        $clientCount = Client::all()->count();

        $moneyTL = 0.0;
        $moneyUSD = 0.0;
        $moneyEURO = 0.0;

        $totalSummary = 0.0;
        $totalSummaryReturn = "";

        foreach ($data as $rowPayments) {
            if ($rowPayments->currency == "TRY") {
                $moneyTL += $rowPayments->payment_amount;
            } elseif ($rowPayments->currency == "USD") {
                $moneyUSD += $rowPayments->payment_amount;
            } elseif ($rowPayments->currency == "EUR") {
                $moneyEURO += $rowPayments->payment_amount;
            }
        }

        if(settings()->get("app_system_currency") == "TRY"){
            $totalSummary = TCMB_Converter('TRY', 'USD', $moneyUSD) + TCMB_Converter('TRY', 'EUR', $moneyEURO) + $moneyTL;
            $totalSummaryReturn = "".Money::TRY($totalSummary, true);
        } elseif(settings()->get("app_system_currency") == "USD"){
            $totalSummary = TCMB_Converter('USD', 'TRY', $moneyTL) + TCMB_Converter('USD', 'EUR', $moneyEURO) + $moneyUSD;
            $totalSummaryReturn = "".Money::USD($totalSummary, true);
        } elseif(settings()->get("app_system_currency") == "EUR"){
            $totalSummary = TCMB_Converter('EUR', 'TRY', $moneyTL) + TCMB_Converter('EUR', 'USD', $moneyUSD) + $moneyEURO;
            $totalSummaryReturn = "".Money::EUR($totalSummary, true);
        }

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('clientName', function ($row_clientName) {
                    return $row_clientName->linkedClient->linkedUser->getUserFullName();
                })
                ->addColumn('companyName', function ($row_companyName) {
                    return $row_companyName->linkedClient->company_name;
                })
                ->addColumn('paymentAmount', function ($row_paymentAmount) {
                    return $row_paymentAmount->payment_amount." (".$row_paymentAmount->currency.")";
                })
                ->addColumn('smsModuleStatus', function ($row_smsModuleStatus) {
                    return ($row_smsModuleStatus->linkedClient->linkedClientModules->sms_module) ? '<span class="badge rounded-pill badge-light-success">'.__('messages.users.form.05.01').'</span>' : '<span class="badge rounded-pill badge-light-danger">'.__('messages.users.form.05.02').'</span>';

                })
                ->addColumn('userStatus', function ($row_userStatus) {
                })
                ->addColumn('remainingDays', function ($row_remainingDays) {
                    $paymentOrder = PaymentOrder::where('client_id', $row_remainingDays->linkedClient->id)->orderBy('created_at', 'desc')->first();

                    if($paymentOrder->status == 1) {
                        return '<span class="badge rounded-pill badge-light-success">'.__('messages.payment_orders.form.06.01').'</span>';
                    } elseif ($paymentOrder->status == 2) {
                        if(intval((strtotime($paymentOrder->payment_date)-strtotime(Carbon::now())) / (60 * 60 * 24)) > 0) {
                            return '<span class="badge rounded-pill badge-light-success">'.intval((strtotime($paymentOrder->payment_date)-strtotime(Carbon::now())) / (60 * 60 * 24))." ".__('messages.payment_periods.index.05').'</span>';
                        } elseif (intval((strtotime($paymentOrder->payment_date)-strtotime(Carbon::now())) / (60 * 60 * 24)) >= -3) {
                            return '<span class="badge rounded-pill badge-light-warning">'.intval((strtotime($paymentOrder->payment_date)-strtotime(Carbon::now())) / (60 * 60 * 24))." ".__('messages.payment_periods.index.05').'</span>';
                        } elseif (intval((strtotime($paymentOrder->payment_date)-strtotime(Carbon::now())) / (60 * 60 * 24)) >= -4) {
                            return '<span class="badge rounded-pill badge-light-danger">'.intval((strtotime($paymentOrder->payment_date)-strtotime(Carbon::now())) / (60 * 60 * 24))." ".__('messages.payment_periods.index.05').'</span>'.'<span class="badge rounded-pill badge-light-warning">'.__('messages.payment_periods.index.06').'</span>';
                        }
                    }
                })
                ->rawColumns(['paymentStatus', 'remainingDays', 'smsModuleStatus'])
                ->make(true);
        }

        return view('pages.payment_periods.payment_periods_index', compact('totalSummaryReturn', 'clientCount'));
    }

    public function create()
    {
        $clients = Client::where('payment_period_id', null)->get();
        return view('pages.payment_periods.payment_periods_create', compact('clients'));
    }

    public function store(PaymentPeriodRequest $request)
    {
        $paymentPeriod = new PaymentPeriod();
        $paymentPeriod->client_id = $request['input-client_id'];
        $paymentPeriod->payment_start_date = $request['input-payment_start_date'];
        $paymentPeriod->payment_amount = $request['input-payment_amount'];
        $paymentPeriod->currency = $request['input-currency'];
        $paymentPeriod->show_delayed_payment_warnings = $request['input-show_delayed_payment_warnings'];
        $paymentPeriod->created_by = Auth::user()->id;
        $paymentPeriod->save();

        $paymentOrder = new PaymentOrder();
        $paymentOrder->client_id = $paymentPeriod->client_id;
        $paymentOrder->order_creation_date = Carbon::now();
        $paymentOrder->payment_date = setNextPaymentDate($request['input-payment_start_date']);
        $paymentOrder->payment_amount = $request['input-payment_amount'];
        $paymentOrder->currency = $request['input-currency'];
        $paymentOrder->status = 1;
        $paymentOrder->invoice_type = 1;
        $paymentOrder->save();

        $client = Client::find($paymentPeriod->client_id);
        $client->payment_period_id = $paymentPeriod->id;
        $client->save();

        return redirect()->route('PaymentPeriods.Index')
            ->with('result','success')
            ->with('title',__('messages.alerts.01'))
            ->with('content',__('messages.alerts.02'));
    }

    public function edit(string $id)
    {
        $clients = Client::where('payment_period_id', null)->get();
        $paymentPeriod = PaymentPeriod::find($id);
        return view('pages.payment_periods.payment_periods_edit', compact('paymentPeriod', 'clients'));
    }

    public function update(PaymentPeriodRequest $request, string $id)
    {
        $paymentPeriod = PaymentPeriod::find($id);
        $paymentPeriod->payment_start_date = $request['input-payment_start_date'];
        $paymentPeriod->payment_amount = $request['input-payment_amount'];
        $paymentPeriod->currency = $request['input-currency'];
        $paymentPeriod->show_delayed_payment_warnings = $request['input-show_delayed_payment_warnings'];
        $paymentPeriod->updated_by = Auth::user()->id;
        $paymentPeriod->save();

        return redirect()->route('PaymentPeriods.Edit', $id)
            ->with('result','warning')
            ->with('title',__('messages.alerts.01'))
            ->with('content',__('messages.alerts.04'));
    }

    public function destroy(string $id)
    {
        $paymentPeriod = PaymentPeriod::find($id);
        $paymentOrders = PaymentOrder::where('client_id', $paymentPeriod->client_id)->get();
        $client = Client::find($paymentPeriod->client_id);
        $client->payment_period_id = null;
        $client->save();

        foreach ($paymentOrders as $paymentOrder) {
            $paymentOrder->update([
                'deleted_by' => Auth::user()->id
            ]);
            $paymentOrder->delete();
        }

        $paymentPeriod->update([
            'deleted_by' => Auth::user()->id
        ]);

        $paymentPeriod->delete();

        return response()->json([
            'status' => 'success',
            'title' => __('messages.alerts.01'),
            'message' => __('messages.alerts.03')
        ]);
    }
}
