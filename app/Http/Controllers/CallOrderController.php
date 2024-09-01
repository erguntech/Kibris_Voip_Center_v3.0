<?php

namespace App\Http\Controllers;

use App\Models\AsteriskCallLog;
use App\Models\CallCenterClient;
use App\Models\CallCenterClientComment;
use App\Models\CallCenterClientSms;
use App\Models\ClientModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class CallOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Şirket Yöneticisi|Şirket Kullanıcısı'],['only' => ['index', 'details', 'getDetails']]);
    }

    public function index(Request $request)
    {
        $assignedData = CallCenterClient::where('client_id', Auth::user()->linkedClient->id)->where('assigned_user_id', Auth::user()->id)->get();

        $totalAssignedDataCount = $assignedData->count();
        $totalCalledActiveDataCount = CallCenterClient::where('is_active', true)->where('assigned_user_id', Auth::user()->id)->where('status', '!=', 0)->get()->count();
        $totalUncalledDataCount = CallCenterClient::where('is_active', true)->where('assigned_user_id', Auth::user()->id)->where('status', 0)->get()->count();

        if(Auth::user()->linkedEmployee->extension_no =! null) {
            $isAssigned = true;
        } else {
            $isAssigned = false;
        }

        if ($request->ajax()) {
            return Datatables::of($assignedData)
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
                    return $row_recordStatus->is_active;
                })
                ->addColumn('callStatus', function ($row_callStatus) {
                    switch ($row_callStatus->status) {
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
                ->rawColumns(['callStatus'])
                ->make(true);
        }

        return view('pages.call_orders.call_orders_index', compact('totalAssignedDataCount', 'totalCalledActiveDataCount', 'totalUncalledDataCount', 'isAssigned'));
    }

    public function details(string $id)
    {
        $callCenterClient = CallCenterClient::find($id);
        $previousRecord = CallCenterClient::where('id', '<', $callCenterClient->id)->where('assigned_user_id', Auth::user()->id)->max('id');
        $nextRecord = CallCenterClient::where('id', '>', $callCenterClient->id)->where('assigned_user_id', Auth::user()->id)->min('id');

        $clientModule = ClientModule::where('client_id',$callCenterClient->client_id)->first();

        return view('pages.call_orders.call_orders_detail', compact('callCenterClient', 'previousRecord', 'nextRecord', 'clientModule'));
    }

    public function getDetails(Request $request)
    {
        $data = null;
        $contactNo = null;

        if ($request['communicationType'] == "0") {
            $data = AsteriskCallLog::find($request['uniqueID']);
            if (@$data->linkedUser->linkedEmployee != null) {
                if (@$data->linkedUser->linkedEmployee->show_numbers == true) {
                    $contactNo = $data->linkedCallCenterClient->contact_no;
                } else {
                    $contactNo = "*** *** *** ***";
                }
            } else {
                $contactNo = $data->linkedCallCenterClient->contact_no;
            }
        } elseif ($request['communicationType'] == "1") {
            $data = CallCenterClientComment::find($request['uniqueID']);
            if (@$data->linkedUser->linkedEmployee != null) {
                if (@$data->linkedUser->linkedEmployee->show_numbers == true) {
                    $contactNo = $data->linkedCallCenterClient->contact_no;
                } else {
                    $contactNo = "*** *** *** ***";
                }
            } else {
                $contactNo = $data->linkedCallCenterClient->contact_no;
            }
        } elseif ($request['communicationType'] == "2") {
            $data = CallCenterClientSms::find($request['uniqueID']);
            if (@$data->linkedUser->linkedEmployee != null) {
                if (@$data->linkedUser->linkedEmployee->show_numbers == true) {
                    $contactNo = $data->linkedCallCenterClient->contact_no;
                } else {
                    $contactNo = "*** *** *** ***";
                }
            } else {
                $contactNo = $data->linkedCallCenterClient->contact_no;
            }
        }

        return response()->json([
            'name' => $data->linkedCallCenterClient->getClientFullName(),
            'phone' => $contactNo,
            'createdBy' => $data->createdUser->getUserFullName(),
            'creationDate' => date('d-m-Y H:i', strtotime($data->created_at)),
        ]);
    }


}
