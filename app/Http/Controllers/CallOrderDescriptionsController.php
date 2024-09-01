<?php

namespace App\Http\Controllers;

use App\Models\AsteriskCallLog;
use App\Models\CallCenterClientComment;
use App\Models\CallCenterClientSms;

use Illuminate\Http\Request;
use Datatables;
use Illuminate\Support\Collection;

class CallOrderDescriptionsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Şirket Yöneticisi|Şirket Kullanıcısı'],['only' => ['index']]);
    }

    public function index(Request $request)
    {
        $dataPool = new Collection();

        $dataComment = CallCenterClientComment::where('call_center_client_id', $request->clientID)->get();
        $dataSMS = CallCenterClientSms::where('call_center_client_id', $request->clientID)->get();
        $dataCall = AsteriskCallLog::where('call_center_client_id', $request->clientID)->get();

        $count = 1;

        foreach ($dataCall as $dataCallContent) {
            $dataPool->push(([
                'id' => $count,
                'unique_id' => $dataCallContent->id,
                'communication_type' => 0,
                'content' => $dataCallContent->call_id,
                'status' => $dataCallContent->status,
                'creation_date' => $dataCallContent->created_at,
                'created_user' => $dataCallContent->createdUser->getUserFullName(),
            ]));
            $count +=1;
        }

        foreach ($dataComment as $dataCommentContent) {
            $dataPool->push(([
                'id' => $count,
                'unique_id' => $dataCommentContent->id,
                'communication_type' => 1,
                'content' => $dataCommentContent->comment_content,
                'status' => $dataCommentContent->saved_status_id,
                'creation_date' => $dataCommentContent->created_at,
                'created_user' => $dataCommentContent->createdUser->getUserFullName(),
            ]));
            $count +=1;
        }

        foreach ($dataSMS as $dataSMSContent) {
            $dataPool->push(([
                'id' => $count,
                'unique_id' => $dataSMSContent->id,
                'communication_type' => 2,
                'content' => $dataSMSContent->sms_content,
                'status' => $dataSMSContent->response_message,
                'creation_date' => $dataSMSContent->created_at,
                'created_user' => $dataSMSContent->createdUser->getUserFullName(),
            ]));
            $count +=1;
        }

        if ($request->ajax()) {
            return Datatables::of($dataPool)
                ->addIndexColumn()
                ->addColumn('uniqueID', function ($row_uniqueID) {
                    return $row_uniqueID['unique_id'];
                })
                ->addColumn('communicationType', function ($row_communicationType) {
                    switch ($row_communicationType['communication_type']) {
                        case "0":
                            return '<span class="badge rounded-pill badge-light-info">'.__('messages.call_orders.detail.datatables.01.00').'</span>';
                        case "1":
                            return '<span class="badge rounded-pill badge-light-primary">'.__('messages.call_orders.detail.datatables.01.01').'</span>';
                        case "2":
                            return '<span class="badge rounded-pill badge-light-success">'.__('messages.call_orders.detail.datatables.01.02').'</span>';
                        default:
                            return [];
                    }
                })
                ->addColumn('communicationStatus', function ($row_communicationStatus) {
                    if ($row_communicationStatus['communication_type'] == 0) {
                        return '<span class="badge rounded-pill badge-light-info">'.__('messages.call_orders.detail.datatables.01.00').'</span>';
                    } elseif ($row_communicationStatus['communication_type'] == 1) {
                        switch ($row_communicationStatus['status']) {
                            case "0":
                                return '<span class="badge rounded-pill badge-light-primary">'.__('messages.call_orders.detail.datatables.04.00').'</span>';
                            case "1":
                                return '<span class="badge rounded-pill badge-light-primary">'.__('messages.call_orders.detail.datatables.04.01').'</span>';
                            case "2":
                                return '<span class="badge rounded-pill badge-light-primary">'.__('messages.call_orders.detail.datatables.04.02').'</span>';
                            case "3":
                                return '<span class="badge rounded-pill badge-light-primary">'.__('messages.call_orders.detail.datatables.04.03').'</span>';
                            case "4":
                                return '<span class="badge rounded-pill badge-light-primary">'.__('messages.call_orders.detail.datatables.04.04').'</span>';
                            case "5":
                                return '<span class="badge rounded-pill badge-light-primary">'.__('messages.call_orders.detail.datatables.04.05').'</span>';
                            case "6":
                                return '<span class="badge rounded-pill badge-light-primary">'.__('messages.call_orders.detail.datatables.04.06').'</span>';
                            case "7":
                                return '<span class="badge rounded-pill badge-light-primary">'.__('messages.call_orders.detail.datatables.04.07').'</span>';
                            case "8":
                                return '<span class="badge rounded-pill badge-light-primary">'.__('messages.call_orders.detail.datatables.04.08').'</span>';
                            default:
                                return [];
                        }
                    } elseif ($row_communicationStatus['communication_type'] == 2) {
                        return '<span class="badge rounded-pill badge-light-success">'.__('messages.call_orders.detail.datatables.01.02').'</span>';
                    }
                })
                ->addColumn('creationDate', function ($row_creationDate) {
                    return date('d-m-Y H:i', strtotime($row_creationDate['creation_date']));
                })
                ->addColumn('createdUser', function ($row_createdUser) {
                    return $row_createdUser['created_user'];
                })
                ->rawColumns(['communicationType', 'communicationStatus'])
                ->make(true);
        }
    }
}
