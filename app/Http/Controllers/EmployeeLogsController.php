<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\DataTables;

class EmployeeLogsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Şirket Yöneticisi'],['only' => ['index', 'showLogData']]);
    }

    public function index(Request $request)
    {
        $dataPool = new Collection();

        $employees = Employee::where('client_id', Auth::user()->linkedClient->id)->get();

        foreach ($employees as $employee) {
            $empLogs = Activity::where('causer_id', $employee->user_id)->get();
            foreach ($empLogs as $empLog) {
                $dataPool->push($empLog);
            }
        }

        if ($request->ajax()) {
            return Datatables::of($dataPool)
                ->addIndexColumn()
                ->addColumn('causerName', function ($row_causerName) {
                    return $row_causerName->getExtraProperty('Causer Name');
                })
                ->addColumn('ipAddress', function ($row_ipAddress) {
                    return $row_ipAddress->getExtraProperty('IP Address');
                })
                ->addColumn('logDescription', function ($row_logDescription) {
                    if ($row_logDescription->description == "created") {
                        return '<span class="badge rounded-pill badge-light-success">'.__('messages.activity_logs.properties.login').'</span>';
                    } else if($row_logDescription->description == "updated") {
                        return '<span class="badge rounded-pill badge-light-warning">'.__('messages.activity_logs.properties.logout').'</span>';
                    } else if($row_logDescription->description == "deleted") {
                        return '<span class="badge rounded-pill badge-light-danger">'.__('messages.activity_logs.properties.created').'</span>';
                    } else if($row_logDescription->description == "Login Activity") {
                        return '<span class="badge rounded-pill badge-light-primary">'.__('messages.activity_logs.properties.updated').'</span>';
                    } else if($row_logDescription->description == "Logout Activity") {
                        return '<span class="badge rounded-pill badge-light-danger">'.__('messages.activity_logs.properties.deleted').'</span>';
                    }
                })
                ->rawColumns(['logDescription'])
                ->make(true);
        }

        return view('pages.activity_logs.activity_logs_employees');
    }

    public function showLogData(Request $request)
    {
        $data = Activity::find($request->id);
        return response()->json([
            "status" => "Success",
            "content" => $data->properties
        ]);
    }
}
