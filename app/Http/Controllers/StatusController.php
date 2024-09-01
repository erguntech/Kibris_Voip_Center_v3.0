<?php

namespace App\Http\Controllers;

use Akaunting\Money\Money;
use App\Models\CallCenterClient;
use App\Models\Client;
use App\Models\ClientModule;
use App\Models\PaymentOrder;
use App\Models\PaymentPeriod;
use App\Models\SMSDevice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
    public function userDeactivated()
    {
        if (Auth::user()->is_active == false) {
            return view('pages.error_pages.account_deactivated');
        } else {
            $userType = Auth::user()->user_type;
            $client = Auth::user()->linkedClient;

            switch ($userType) {
                case "1":
                    $diskTotalSpace = disk_total_space("/");
                    $diskFreeSpace = disk_free_space("/");
                    $diskUsedSpace = $diskTotalSpace - $diskFreeSpace;
                    $diskPercentage = ($diskUsedSpace / $diskTotalSpace) * 100;

                    $totalUserCount = User::all()->count();
                    $totalCustomerCount = Client::all()->count();
                    $clientsUpcomingPayments = PaymentOrder::where('status', 2)->get();
                    $smsDevicesLowCredit = SMSDevice::where('credit_count', '<=', 100)->where('is_active', true)->get();
                    $smsClientsLowCredit = ClientModule::where('sms_credits', '<=', 100)->where('sms_module', true)->get();

                    $data = PaymentPeriod::all();

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

                    return view('pages.dashboards.dashboard_administration_index', compact('totalUserCount', 'totalCustomerCount', 'totalSummaryReturn', 'clientsUpcomingPayments', 'smsDevicesLowCredit', 'smsClientsLowCredit', 'diskTotalSpace', 'diskFreeSpace', 'diskUsedSpace', 'diskPercentage')) ;
                    break;
                case "2":
                    // Admin User
                    break;
                case "3":
                    $paymentOrder = PaymentOrder::where('client_id', $client->id)->orderBy('created_at', 'desc')->first();
                    return view('pages.dashboards.dashboard_clients_index', compact('paymentOrder'));
                    break;
                case "4":
                    $assignedData = CallCenterClient::where('client_id', Auth::user()->linkedClient->id)->where('assigned_user_id', Auth::user()->id)->latest()->take(5)->get();
                    return view('pages.dashboards.dashboard_employees_index', compact('assignedData'));
                    break;
                default:
                    abort(403, 'Unauthorized Access');
            }
        }
    }

    public function moduleDeactivated()
    {
        return view('pages.error_pages.module_deactivated');
    }
}
