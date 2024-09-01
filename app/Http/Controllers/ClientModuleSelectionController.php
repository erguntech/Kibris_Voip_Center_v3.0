<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientModule;
use App\Models\SMSDevice;
use Illuminate\Http\Request;
use App\Http\Requests\ClientModuleSelectionRequest;
use Illuminate\Support\Collection;

class ClientModuleSelectionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Sistem Yöneticisi|Sistem Kullanıcısı'],['only' => ['index', 'update']]);
    }

    public function index(string $id)
    {
        $client = Client::find($id);
        $clientModel = ClientModule::where('client_id', $id)->first();
        $availableSMSDevices = SMSDevice::where('is_active', true)->where('assigned_client_id', null)->get();

        if ($clientModel->sms_module == true) {
            $clientSMSDevice = SMSDevice::where('assigned_client_id', $id)->first();
        } else {
            $clientSMSDevice = null;
        }

        return view('pages.clients.clients_module_selection', compact('client', 'clientModel', 'availableSMSDevices', 'clientSMSDevice'));
    }

    public function update(ClientModuleSelectionRequest $request, string $id)
    {
        $client = Client::find($id);
        $clientModel = ClientModule::where('client_id', $client->id)->first();
        $SMSDeviceOld = SMSDevice::find($clientModel->sms_module_device_id);

        if ($clientModel->sms_module_device_id != null) {
            if ($clientModel->sms_module_device_id != $request['input-sms_module_device_id']) {
                $SMSDeviceOld->assigned_client_id = null;
                $SMSDeviceOld->save();
            }
        }

        if ($request['input-pbx_module'] == "1") {
            $clientModel->pbx_module = true;
            $clientModel->pbx_server_ip_address = $request['input-pbx_server_ip_address'];
        } else if($request['input-pbx_module'] == "0"){
            $clientModel->pbx_module = false;
            $clientModel->pbx_server_ip_address = null;
        }

        if ($request['input-sms_module'] == "1") {
            $clientModel->sms_module = true;
            $clientModel->sms_module_device_id = $request['input-sms_module_device_id'];
            $SMSDeviceNew = SMSDevice::find($request['input-sms_module_device_id']);
            $SMSDeviceNew->assigned_client_id = $clientModel->linkedClient->id;
            $SMSDeviceNew->save();
        } else if($request['input-sms_module'] == "0"){
            if ($clientModel->sms_module_device_id != null) {
                $SMSDeviceOld->assigned_client_id = null;
                $SMSDeviceOld->save();
            }
            $clientModel->sms_module = false;
            $clientModel->sms_module_device_id = null;
        }

        $clientModel->save();

        return redirect()->route('Clients.ModuleSelection.Index', $id)
            ->with('result','warning')
            ->with('title',__('messages.alerts.01'))
            ->with('content',__('messages.alerts.04'));
    }
}
