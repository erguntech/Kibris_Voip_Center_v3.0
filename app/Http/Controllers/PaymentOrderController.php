<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\PaymentOrder;
use App\Models\PaymentPeriod;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Datatables;
use Illuminate\Support\Facades\Auth;

class PaymentOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Sistem Yöneticisi|Sistem Kullanıcısı'],['only' => ['index', 'approvePayment']]);
    }

    public function index(Request $request)
    {
        $data = PaymentOrder::all();

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
                ->addColumn('paymentStatus', function ($row_paymentStatus) {
                    if($row_paymentStatus->status == 1) {
                        return '<span class="badge rounded-pill badge-light-success">'.__('messages.payment_orders.form.06.01').'</span>';
                    } elseif ($row_paymentStatus->status == 2) {
                        return '<span class="badge rounded-pill badge-light-danger">'.__('messages.payment_orders.form.06.02').'</span>';
                    }
                })
                ->addColumn('remainingDays', function ($row_remainingDays) {
                    if($row_remainingDays->status == 1) {
                        return '<span class="badge rounded-pill badge-light-success">'.__('messages.payment_orders.form.06.01').'</span>';
                    } elseif ($row_remainingDays->status == 2) {
                        if(intval((strtotime($row_remainingDays->payment_date)-strtotime(Carbon::now())) / (60 * 60 * 24)) > 0) {
                            return '<span class="badge rounded-pill badge-light-success">'.intval((strtotime($row_remainingDays->payment_date)-strtotime(Carbon::now())) / (60 * 60 * 24))." ".__('messages.payment_orders.index.05').'</span>';
                        } elseif (intval((strtotime($row_remainingDays->payment_date)-strtotime(Carbon::now())) / (60 * 60 * 24)) >= -3) {
                            return '<span class="badge rounded-pill badge-light-warning">'.intval((strtotime($row_remainingDays->payment_date)-strtotime(Carbon::now())) / (60 * 60 * 24))." ".__('messages.payment_orders.index.05').'</span>';
                        } elseif (intval((strtotime($row_remainingDays->payment_date)-strtotime(Carbon::now())) / (60 * 60 * 24)) >= -4) {
                            return '<span class="badge rounded-pill badge-light-danger">'.intval((strtotime($row_remainingDays->payment_date)-strtotime(Carbon::now())) / (60 * 60 * 24))." ".__('messages.payment_orders.index.05').'</span>'.'<span class="badge rounded-pill badge-light-warning">'.__('messages.payment_orders.index.06').'</span>';
                        }
                    }

                })
                ->rawColumns(['paymentStatus', 'remainingDays'])
                ->make(true);
        }

        return view('pages.payment_orders.payment_orders_index');
    }

    public function approvePayment($id)
    {
        $data = PaymentOrder::find($id);
        $data->status = 1;
        $data->approve_date = Carbon::now();
        $data->save();

        $client = Client::find($data->client_id);

        $user = User::find($client->user_id);
        $user->is_active = true;
        $user->updated_by = Auth::user()->id;
        $user->save();

        $employeeUsers = User::where('client_id', $client->id)->where('id', '!=', $client->user_id)->get();

        foreach ($employeeUsers as $employeeUser) {
            $employeeUser->is_active = true;
            $employeeUser->save();
        }

        return response()->json([
            'status' => 'success',
            'title' => __('messages.alerts.01'),
            'message' => __('messages.alerts.09')
        ]);
    }
}
