<?php

namespace App\Http\Controllers;

use App\Http\Requests\SMSDeviceRequest;
use App\Models\Client;
use App\Models\SMSDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class SMSDeviceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Sistem Yöneticisi|Sistem Kullanıcısı'],['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy']]);
    }

    public function index(Request $request)
    {
        $data = SMSDevice::all();

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('deviceStatus', function ($row_deviceStatus) {
                    return ($row_deviceStatus->is_active) ? '<span class="badge rounded-pill badge-light-success">'.__('messages.sms_devices.form.06.01').'</span>' : '<span class="badge rounded-pill badge-light-danger">'.__('messages.sms_devices.form.06.02').'</span>';
                })
                ->addColumn('assignedClient', function ($row_assignedClient) {
                    if ($row_assignedClient->assigned_client_id != null) {
                        return '<span class="badge rounded-pill badge-light-success">'.$row_assignedClient->linkedClient->company_name.'</span>';
                    } else {
                        return '<span class="badge rounded-pill badge-light-warning">'.__('messages.sms_devices.index.datatables.03.01').'</span>';
                    }
                })
                ->addColumn('remainingCredits', function ($row_remainingCredits) {
                    if ($row_remainingCredits->credit_count >= 100) {
                        return '<span class="badge rounded-pill badge-light-success">'.Number::format($row_remainingCredits->credit_count).'</span>';
                    } else {
                        return '<span class="badge rounded-pill badge-light-warning">'.Number::format($row_remainingCredits->credit_count).'</span>';
                    }
                })
                ->rawColumns(['deviceStatus', 'assignedClient', 'remainingCredits'])
                ->make(true);
        }

        return view('pages.sms_devices.sms_devices_index');
    }

    public function create()
    {
        $clients = Client::where('payment_period_id', null)->get();
        return view('pages.sms_devices.sms_devices_create', compact('clients'));
    }

    public function store(SMSDeviceRequest $request)
    {
        $SMSDevice = new SMSDevice();
        $SMSDevice->device_name = $request['input-device_name'];
        $SMSDevice->phone_no = $request['input-phone_no'];
        $SMSDevice->gsm_api_token = $request['input-gsm_api_token'];
        $SMSDevice->credit_count = $request['input-credit_count'];
        $SMSDevice->is_active = $request['input-is_active'];
        $SMSDevice->created_by = Auth::user()->id;
        $SMSDevice->save();

        return redirect()->route('SMSDevices.Index')
            ->with('result','success')
            ->with('title',__('messages.alerts.01'))
            ->with('content',__('messages.alerts.02'));
    }

    public function edit(string $id)
    {
        $SMSDevice = SMSDevice::find($id);
        $clients = Client::where('payment_period_id', null)->get();
        return view('pages.sms_devices.sms_devices_edit', compact('SMSDevice', 'clients'));
    }

    public function update(SMSDeviceRequest $request, string $id)
    {
        $SMSDevice = SMSDevice::find($id);
        $SMSDevice->device_name = $request['input-device_name'];
        $SMSDevice->phone_no = $request['input-phone_no'];
        $SMSDevice->gsm_api_token = $request['input-gsm_api_token'];
        $SMSDevice->credit_count = $request['input-credit_count'];
        $SMSDevice->is_active = $request['input-is_active'];
        $SMSDevice->updated_by = Auth::user()->id;
        $SMSDevice->save();

        return redirect()->route('SMSDevices.Edit', $id)
            ->with('result','warning')
            ->with('title',__('messages.alerts.01'))
            ->with('content',__('messages.alerts.04'));
    }

    public function destroy(string $id)
    {
        $SMSDevice = SMSDevice::find($id);

        $SMSDevice->update([
            'is_active' => false,
            'deleted_by' => Auth::user()->id
        ]);

        $SMSDevice->delete();

        return response()->json([
            'status' => 'success',
            'title' => __('messages.alerts.01'),
            'message' => __('messages.alerts.03')
        ]);
    }
}
