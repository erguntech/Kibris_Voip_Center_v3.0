<?php

namespace App\Http\Controllers;

use Akaunting\Money\Money;
use App\Models\PaymentOrder;
use App\Models\PaymentPeriod;
use App\Models\SMSCreditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Datatables;
use Carbon\Carbon;

class MyInvoicesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Şirket Yöneticisi|Sistem Yöneticisi|Sistem Kullanıcısı'],['only' => ['index', 'showInvoiceDetail']]);
    }

    public function index(Request $request)
    {
        $data = PaymentOrder::where('client_id', Auth::user()->linkedClient->id);

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('clientName', function ($row_clientName) {
                    return $row_clientName->linkedClient->linkedUser->getUserFullName();
                })
                ->addColumn('paymentAmount', function ($row_paymentAmount) {
                    if ($row_paymentAmount->currency == "TRY") {
                        $paymentValue = "".Money::TRY($row_paymentAmount->payment_amount, true);
                    } elseif ($row_paymentAmount->currency == "USD") {
                        $paymentValue = "".Money::USD($row_paymentAmount->payment_amount, true);
                    } elseif ($row_paymentAmount->currency == "EUR") {
                        $paymentValue = "".Money::EUR($row_paymentAmount->payment_amount, true);
                    }

                    return $paymentValue;
                })
                ->addColumn('paymentStatus', function ($row_paymentStatus) {
                    if($row_paymentStatus->status == 1) {
                        return '<span class="badge rounded-pill badge-light-success">'.__('messages.payment_orders.form.06.01').'</span>';
                    } elseif ($row_paymentStatus->status == 2) {
                        return '<span class="badge rounded-pill badge-light-danger">'.__('messages.payment_orders.form.06.02').'</span>';
                    }
                })
                ->rawColumns(['paymentStatus'])
                ->make(true);
        }

        return view('pages.my_invoices.my_invoices_index');
    }

    public function showInvoiceDetail($id)
    {
        $invoice = PaymentOrder::find($id);
        if ($invoice->invoice_type == 2) {
            $smsCreditLog = SMSCreditLog::where('payment_order_id', $id)->first();

            return view('pages.my_invoices.my_invoices_detail', compact('invoice', 'smsCreditLog'));
        } else {
            return view('pages.my_invoices.my_invoices_detail', compact('invoice'));
        }
    }
}
