<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\ClientModule;
use App\Models\Employee;
use App\Models\SMSDevice;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Client;
use Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Sistem Yöneticisi|Sistem Kullanıcısı'],['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy']]);
    }

    public function index(Request $request)
    {
        $data = Client::all();

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('userFullName', function ($row_userFullName) {
                    return $row_userFullName->linkedUser->getUserFullName();
                })
                ->addColumn('userEmail', function ($row_userEmail) {
                    return $row_userEmail->linkedUser->email;
                })
                ->addColumn('pbxStatus', function ($row_pbxStatus) {
                    return $row_pbxStatus->linkedClientModules->pbx_module;
                })
                ->addColumn('userStatus', function ($row_userStatus) {
                    return ($row_userStatus->linkedUser->is_active) ? '<span class="badge rounded-pill badge-light-success">'.__('messages.users.form.05.01').'</span>' : '<span class="badge rounded-pill badge-light-danger">'.__('messages.users.form.05.02').'</span>';
                })
                ->rawColumns(['userStatus'])
                ->make(true);
        }

        $totalUserCount = $data->count();
        $activeClientCount = 0;
        $passiveClientCount = 0;

        foreach ($data as $data_n) {
            if ($data_n->linkedUser->is_active == true) {
                $activeClientCount += 1;
            } elseif ($data_n->linkedUser->is_active == true) {
                $passiveClientCount += 1;
            }
        }

        return view('pages.clients.clients_index', compact('totalUserCount', 'activeClientCount', 'passiveClientCount'));
    }

    public function create()
    {
        $clients = Client::all();
        return view('pages.clients.clients_create', compact('clients'));
    }

    public function store(ClientRequest $request)
    {
        $password = '';

        for($i = 0; $i < 8; $i++) {
            $password .= mt_rand(0, 9);
        }

        $user = new User();
        $user->first_name = $request['input-first_name'];
        $user->last_name = $request['input-last_name'];
        $user->email = $request['input-email'];
        $user->password = bcrypt($password);
        $user->is_active = $request['input-is_active'];
        $user->email_verified_at = now();
        $user->remember_token = Str::random(10);
        $user->created_by = Auth::user()->id;
        $user->client_id = 1;
        $user->user_type = 3;
        $user->save();

        $client = new Client();
        $client->company_name = $request['input-company_name'];
        $client->contact_no = $request['input-contact_no'];
        $client->address = $request['input-address'];
        $client->created_by = Auth::user()->id;
        $client->user_id = $user->id;
        $client->save();

        $user->client_id = $client->id;
        $user->save();

        $clientModel = new ClientModule();
        $clientModel->client_id = $client->id;
        $clientModel->sms_module = false;
        $clientModel->pbx_module = false;
        $clientModel->save();

        $employeeUsers = User::where('client_id', $client->id)->where('id', '!=', $client->user_id)->get();

        foreach ($employeeUsers as $employeeUser) {
            $employeeUser->is_active = $request['input-is_active'];
            $employeeUser->save();
        }

        $user->assignRole("Şirket Yöneticisi");

        return redirect()->route('Clients.Index')
            ->with('result','success')
            ->with('title',__('messages.alerts.01'))
            ->with('content',__('messages.alerts.02'));
    }

    public function edit(string $id)
    {
        $client = Client::find($id);
        return view('pages.clients.clients_edit', compact('client'));
    }

    public function update(ClientRequest $request, string $id)
    {
        $client = Client::find($id);
        $client->company_name = $request['input-company_name'];
        $client->contact_no = $request['input-contact_no'];
        $client->address = $request['input-address'];
        $client->updated_by = Auth::user()->id;
        $client->save();

        $user = User::find($client->user_id);
        $user->first_name = $request['input-first_name'];
        $user->last_name = $request['input-last_name'];
        $user->is_active = $request['input-is_active'];
        $user->updated_by = Auth::user()->id;
        $user->save();

        $employeeUsers = User::where('client_id', $client->id)->where('id', '!=', $client->user_id)->get();

        foreach ($employeeUsers as $employeeUser) {
            $employeeUser->is_active = $request['input-is_active'];
            $employeeUser->save();
        }

        return redirect()->route('Clients.Edit', $id)
            ->with('result','warning')
            ->with('title',__('messages.alerts.01'))
            ->with('content',__('messages.alerts.04'));
    }

    public function destroy(string $id)
    {
        $client = Client::find($id);
        $user = User::find($client->user_id);

        $client->update([
            'is_active' => false,
            'deleted_by' => Auth::user()->id
        ]);

        $user->update([
            'is_active' => false,
            'deleted_by' => Auth::user()->id
        ]);

        $client->delete();
        $user->delete();

        return response()->json([
            'status' => 'success',
            'title' => __('messages.alerts.01'),
            'message' => __('messages.alerts.03')
        ]);
    }
}
