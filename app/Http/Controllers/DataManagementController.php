<?php

namespace App\Http\Controllers;

use App\Models\CallCenterClient;
use App\Models\Client;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelReader;
use ErlandMuchasaj\LaravelFileUploader\FileUploader;
use Datatables;

class DataManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Şirket Yöneticisi'],['only' => ['index', 'downloadExcelTemplate', 'readExcelData', 'assignCallCenterClient', 'dataDistribution']]);
    }

    public function index(Request $request)
    {
        $client = Auth::user()->linkedClient();
        $totalDataCount = CallCenterClient::where('client_id', Auth::user()->linkedClient->id)->get()->count();
        $totalActiveDataCount = CallCenterClient::where('is_active', true)->get()->count();
        $totalPassiveDataCount = CallCenterClient::where('is_active', false)->get()->count();
        $employees = Employee::where('client_id', Auth::user()->linkedClient->id)->get();

        $unassignedData = CallCenterClient::where('client_id', Auth::user()->linkedClient->id)->where('assigned_user_id', null)->get();

        if ($request->ajax()) {
            return Datatables::of($unassignedData)
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
                            return '<span class="badge rounded-pill badge-light-primary">'.__('messages.call_orders.detail.datatables.04.00.01').'</span>';
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

        return view('pages.data_management.data_management_index', compact('totalDataCount', 'totalActiveDataCount', 'totalPassiveDataCount', 'unassignedData', 'employees', 'client'));
    }

    public function downloadExcelTemplate() {
        return Storage::download('assets/templates/Data_Template.xlsx');
    }

    public function readExcelData(Request $request) {
        $dataContainer = array();

        $response = FileUploader::store($request['input-x']);
        $path = storage_path('app/'.$response['path']);
        $count = 0;

        $excelData = SimpleExcelReader::create($path)->getRows()
            ->each(function(array $rowProperties)  use(&$count){
                $count ++;
                $callCenterClient = new CallCenterClient();
                $callCenterClient->client_id = Auth::user()->linkedClient->id;
                $callCenterClient->assigned_user_id = null;
                $callCenterClient->first_name = $rowProperties['Name'];
                $callCenterClient->last_name = $rowProperties['Surname'];
                $callCenterClient->company_name = $rowProperties['Company_Name'];
                $callCenterClient->contact_no = $rowProperties['Phone_Number'];
                $callCenterClient->description = $rowProperties['Description'];
                $callCenterClient->status = 0;
                $callCenterClient->is_active = true;
                $callCenterClient->created_by = Auth::user()->id;
                $callCenterClient->save();
            });

        return response()->json([
            'status' => 'success',
            'title' => __('messages.alerts.01'),
            'message' => __('messages.alerts.03'),
            'recordCount' => $count
        ]);
    }

    public function assignCallCenterClient(Request $request) {
        $employee = Employee::find($request['employeeID']);

        $callCenterClient = CallCenterClient::find($request['id']);
        $callCenterClient->assigned_user_id = $employee->linkedUser->id;
        $callCenterClient->updated_by = Auth::user()->id;
        $callCenterClient->status = 0;
        $callCenterClient->save();

        return response()->json([
            'status' => 'success',
            'title' => __('messages.alerts.01'),
            'message' => __('messages.alerts.03'),
        ]);
    }

    public function getClientCount() {
        $totalDataCount = CallCenterClient::where('client_id', Auth::user()->linkedClient->id)->get()->count();
        $totalActiveDataCount = CallCenterClient::where('is_active', true)->get()->count();
        $totalPassiveDataCount = CallCenterClient::where('is_active', false)->get()->count();

        return response()->json([
            'totalDataCount' => $totalDataCount,
            'totalActiveDataCount' => $totalActiveDataCount,
            'totalPassiveDataCount' => $totalPassiveDataCount
        ]);
    }

    public function dataDistribution() {
        $client = Client::where('id', Auth::user()->linkedClient->id)->first();
        $employees = Employee::where('client_id', Auth::user()->linkedClient->id)->get();
        return view('pages.data_management.data_distribution_index', compact('employees', 'client'));
    }

    public function autoAssign(Request $request) {
        $client = Client::find($request['clientID']);
        $employees = Employee::where('client_id', $client->id)->get();
        $unassignedData = CallCenterClient::where('client_id', $client->id)->where('assigned_user_id', null)->get();
        $chunkCount = $unassignedData->count() / $employees->count();
        $chunks = $unassignedData->chunk($chunkCount);

        foreach ($chunks as $key => $chunk) {
            foreach ($chunk as $callCenterClient) {
                $callCenterClient->assigned_user_id = $employees[$key]->linkedUser->id;
                $callCenterClient->updated_by = Auth::user()->id;
                $callCenterClient->status = 0;
                $callCenterClient->save();
            }
        }

        return response()->json([
            'status' => 'success',
            'title' => __('messages.alerts.01'),
            'message' => __('messages.alerts.03'),
        ]);
    }
}
