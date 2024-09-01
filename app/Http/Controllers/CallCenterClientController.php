<?php

namespace App\Http\Controllers;

use App\Http\Requests\CallCenterClientRequest;
use App\Http\Requests\ClientRequest;
use App\Models\CallCenterClient;
use App\Models\Client;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CallCenterClientController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Şirket Yöneticisi'],['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy']]);
    }

    public function index(Request $request)
    {
        $data = CallCenterClient::where('client_id', Auth::user()->linkedClient->id)->get();
        $dataActiveCount = CallCenterClient::where('client_id', Auth::user()->linkedClient->id)->where('is_active', true)->get()->count();
        $dataPassiveCount = CallCenterClient::where('client_id', Auth::user()->linkedClient->id)->where('is_active', false)->get()->count();

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('fullName', function ($row_fullName) {
                    return $row_fullName->getClientFullName();
                })
                ->addColumn('companyName', function ($row_companyName) {
                    return $row_companyName->company_name;
                })
                ->addColumn('contactNo', function ($row_contactNo) {
                    return $row_contactNo->contact_no;
                })
                ->addColumn('recordStatus', function ($row_recordStatus) {
                    return ($row_recordStatus->is_active) ? '<span class="badge rounded-pill badge-light-success">'.__('messages.users.form.05.01').'</span>' : '<span class="badge rounded-pill badge-light-danger">'.__('messages.users.form.05.02').'</span>';

                })
                ->addColumn('callStatus', function ($row_callStatus) {
                    switch ($row_callStatus->status) {
                        case null:
                            return '<span class="badge rounded-pill badge-light-warning">'.__('messages.call_orders.detail.datatables.04.00.01').'</span>';
                        case "0":
                            return '<span class="badge rounded-pill badge-light-primary">'.__('messages.call_orders.detail.datatables.04.00').'</span>';
                        case "1":
                            return '<span class="badge rounded-pill badge-light-success">'.__('messages.call_orders.detail.datatables.04.01').'</span>';
                        case "2":
                            return '<span class="badge rounded-pill badge-light-danger">'.__('messages.call_orders.detail.datatables.04.02').'</span>';
                        case "3":
                            return '<span class="badge rounded-pill badge-light-info">'.__('messages.call_orders.detail.datatables.04.03').'</span>';
                        case "4":
                            return '<span class="badge rounded-pill badge-light-warning">'.__('messages.call_orders.detail.datatables.04.04').'</span>';
                        case "5":
                            return '<span class="badge rounded-pill badge-light-warning">'.__('messages.call_orders.detail.datatables.04.05').'</span>';
                        case "6":
                            return '<span class="badge rounded-pill badge-light-warning">'.__('messages.call_orders.detail.datatables.04.06').'</span>';
                        case "7":
                            return '<span class="badge rounded-pill badge-light-warning">'.__('messages.call_orders.detail.datatables.04.07').'</span>';
                        case "8":
                            return '<span class="badge rounded-pill badge-light-warning">'.__('messages.call_orders.detail.datatables.04.08').'</span>';
                        default:
                            return [];
                    }
                })
                ->rawColumns(['callStatus', 'recordStatus'])
                ->make(true);
        }

        return view('pages.call_center_clients.call_center_clients_index', compact('dataActiveCount', 'dataPassiveCount'));
    }

    public function create()
    {
        $employees = Employee::where('client_id', Auth::user()->linkedClient->id)->get();
        return view('pages.call_center_clients.call_center_clients_create', compact('employees'));
    }

    public function store(CallCenterClientRequest $request)
    {
        if ($request['input-assigned_user_id'] != "0") {
            $statusValue = 0;
        } else {
            $statusValue = null;
        }

        $callCenterClient = new CallCenterClient();
        $callCenterClient->client_id = Auth::user()->linkedClient->id;
        $callCenterClient->assigned_user_id = $request['input-assigned_user_id'];
        $callCenterClient->first_name = $request['input-first_name'];
        $callCenterClient->last_name = $request['input-last_name'];
        $callCenterClient->company_name = $request['input-company_name'];
        $callCenterClient->contact_no = $request['input-contact_no'];
        $callCenterClient->description = $request['input-description'];
        $callCenterClient->status = $statusValue;
        $callCenterClient->is_active = $request['input-is_active'];
        $callCenterClient->created_by = Auth::user()->id;
        $callCenterClient->save();

        return redirect()->route('CallCenterClients.Index')
            ->with('result','success')
            ->with('title',__('messages.alerts.01'))
            ->with('content',__('messages.alerts.02'));
    }

    public function edit(string $id)
    {
        $employees = Employee::where('client_id', Auth::user()->linkedClient->id)->get();
        $callCenterClient = CallCenterClient::find($id);
        return view('pages.call_center_clients.call_center_clients_edit', compact('callCenterClient', 'employees'));
    }

    public function update(CallCenterClientRequest $request, string $id)
    {
        if ($request['input-assigned_user_id'] != "0") {
            $statusValue = 0;
        } else {
            $statusValue = null;
        }

        $callCenterClient = CallCenterClient::find($id);
        $callCenterClient->assigned_user_id = $request['input-assigned_user_id'];
        $callCenterClient->first_name = $request['input-first_name'];
        $callCenterClient->last_name = $request['input-last_name'];
        $callCenterClient->company_name = $request['input-company_name'];
        $callCenterClient->contact_no = $request['input-contact_no'];
        $callCenterClient->description = $request['input-description'];
        $callCenterClient->status = $statusValue;
        $callCenterClient->is_active = $request['input-is_active'];
        $callCenterClient->updated_by = Auth::user()->id;
        $callCenterClient->save();

        return redirect()->route('CallCenterClients.Edit', $id)
            ->with('result','warning')
            ->with('title',__('messages.alerts.01'))
            ->with('content',__('messages.alerts.04'));
    }

    public function destroy(string $id)
    {
        $callCenterClient = CallCenterClient::find($id);

        $callCenterClient->update([
            'is_active' => false,
            'deleted_by' => Auth::user()->id
        ]);

        $callCenterClient->delete();

        return response()->json([
            'status' => 'success',
            'title' => __('messages.alerts.01'),
            'message' => __('messages.alerts.03')
        ]);
    }
}
