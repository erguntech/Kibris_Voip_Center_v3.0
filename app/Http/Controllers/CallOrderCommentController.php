<?php

namespace App\Http\Controllers;

use App\Models\CallCenterClient;
use App\Models\CallCenterClientComment;
use App\Models\CallCenterClientSms;
use Illuminate\Http\Request;
use Datatables;
use Illuminate\Support\Facades\Auth;

class CallOrderCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Şirket Yöneticisi|Şirket Kullanıcısı'],['only' => ['postComment']]);
    }

    public function postComment(Request $request)
    {
        $callCenterClient = CallCenterClient::find($request->id);

        $callCenterClientComment = new CallCenterClientComment();
        $callCenterClientComment->client_id = $callCenterClient->client_id;
        $callCenterClientComment->assigned_user_id = $callCenterClient->assigned_user_id;
        $callCenterClientComment->call_center_client_id = $callCenterClient->id;
        $callCenterClientComment->saved_status_id = $request->status;
        $callCenterClientComment->comment_content = $request->description;;
        $callCenterClientComment->is_active = true;
        $callCenterClientComment->created_by = Auth::user()->id;
        $callCenterClientComment->save();

        $callCenterClient->status = $request->status;
        $callCenterClient->save();

        return response()->json([
            "status" => "Success",
        ]);
    }
}
