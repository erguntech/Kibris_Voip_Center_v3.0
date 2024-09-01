<?php

namespace App\Http\Controllers;

use App\Http\Classes\SMSCalculator;
use App\Models\CallCenterClient;
use App\Models\CallCenterClientSms;
use App\Models\ClientModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CallOrderSmsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Şirket Yöneticisi|Şirket Kullanıcısı'],['only' => ['postSMS']]);
    }

    public function postSMS(Request $request)
    {
        $smsContent = $request->sms_content;

        // SMS Content Character Replacer
        $searchChars = array('Ç','ç','Ğ','ğ','ı','İ','Ö','ö','Ş','ş','Ü','ü');
        $replaceChars = array('c','c','g','g','i','i','o','o','s','s','u','u');
        $smsContent_Converted = str_replace($searchChars, $replaceChars, $smsContent);

        $SmsCalc = new SMSCalculator();
        $smsCreditCount = $SmsCalc->getPartCount($smsContent_Converted);

        $callCenterClient = CallCenterClient::find($request->id);

        $callCenterClientGSM =  $callCenterClient->contact_no;

        $pathToSendSMS = public_path('assets/js/custom/sendsms.js');
        $command = "node ".$pathToSendSMS." ".$callCenterClientGSM." ".$smsContent;
        $output = shell_exec($command);

        $callCenterClientSMS = new CallCenterClientSms();
        $callCenterClientSMS->client_id = $callCenterClient->client_id;
        $callCenterClientSMS->assigned_user_id = $callCenterClient->assigned_user_id;
        $callCenterClientSMS->call_center_client_id = $callCenterClient->id;
        $callCenterClientSMS->sms_content = $smsContent;
        $callCenterClientSMS->response_message = $output;
        $callCenterClientSMS->created_by = Auth::user()->id;
        $callCenterClientSMS->save();

        $clientModule = ClientModule::where('client_id', $callCenterClientSMS->client_id)->first();
        $clientModule->sms_credits = $clientModule->sms_credits - $smsCreditCount;
        $clientModule->save();

        return response()->json([
            'status' => 'success',
            'message' => $smsContent_Converted,
            'credits' => $clientModule->sms_credits,
        ]);
    }
}
