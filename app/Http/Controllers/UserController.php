<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UserRequest;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Sistem Yöneticisi'],['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy', 'getUserNameData']]);
    }

    public function index(Request $request)
    {
        $data = User::all();

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('userFullName', function ($row_userFullName) {
                    return $row_userFullName->getUserFullName();
                })
                ->addColumn('userCompany', function ($row_userCompany) {
                    if ($row_userCompany->client_id == "0") {
                        return '<span class="badge rounded-pill badge-light-success">'.settings('app_name').'</span>';
                    } else {
                        return '<span class="badge rounded-pill badge-light-primary">'.$row_userCompany->linkedClient->company_name.'</span>';
                    }
                })
                ->addColumn('userStatus', function ($row_userStatus) {
                    return ($row_userStatus->is_active) ? '<span class="badge rounded-pill badge-light-success">'.__('messages.users.form.05.01').'</span>' : '<span class="badge rounded-pill badge-light-danger">'.__('messages.users.form.05.02').'</span>';
                })
                ->rawColumns(['userType', 'userCompany', 'userStatus'])
                ->make(true);
        }

        $totalUserCount = $data->count();
        $activeUserCount = User::where('is_active', true)->get()->count();
        $passiveUserCount = User::where('is_active', false)->get()->count();

        return view('pages.users.users_index', compact('totalUserCount', 'activeUserCount', 'passiveUserCount'));
    }

    public function create()
    {
        $roles = Role::all();
        $clients = Client::all();
        return view('pages.users.users_create', compact('roles', 'clients'));
    }

    public function store(UserRequest $request)
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
        $user->client_id = $request['input-client_id'];
        $user->user_type = $request['input-user_type'];
        $user->is_active = $request['input-is_active'];
        $user->email_verified_at = now();
        $user->remember_token = Str::random(10);
        $user->created_by = Auth::user()->id;
        $user->save();

        switch ($request['input-user_type']) {
            case "1":
                $user->assignRole("Sistem Yöneticisi");
                break;
            case "2":
                $user->assignRole("Sistem Kullanıcısı");
                break;
            case "3":
                $user->assignRole("Şirket Yöneticisi");
                break;
            case "4":
                $user->assignRole("Şirket Kullanıcısı");
                break;
            default:
        }

        return redirect()->route('Users.Index')
            ->with('result','success')
            ->with('title',__('messages.alerts.01'))
            ->with('content',__('messages.alerts.02'));
    }

    public function edit(string $id)
    {
        $user = User::find($id);
        $clients = Client::all();
        return view('pages.users.users_edit', compact('user', 'clients'));
    }

    public function update(UserRequest $request, string $id)
    {
        $user = User::find($id);
        $user->first_name = $request['input-first_name'];
        $user->last_name = $request['input-last_name'];
        $user->client_id = $request['input-client_id'];
        $user->user_type = $request['input-user_type'];
        $user->is_active = $request['input-is_active'];
        $user->updated_by = Auth::user()->id;
        $user->save();

        switch ($request['input-user_type']) {
            case "1":
                $user->syncRoles("Sistem Yöneticisi");
                break;
            case "2":
                $user->syncRoles("Sistem Kullanıcısı");
                break;
            case "3":
                $user->syncRoles("Şirket Yöneticisi");
                break;
            case "4":
                $user->syncRoles("Şirket Kullanıcısı");
                break;
            default:
        }

        return redirect()->route('Users.Edit', $id)
            ->with('result','warning')
            ->with('title',__('messages.alerts.01'))
            ->with('content',__('messages.alerts.04'));
    }

    public function destroy(string $id)
    {
        $user = User::find($id);

        $user->update([
            'deleted_by' => Auth::user()->id
        ]);

        $user->delete();

        return response()->json([
            'status' => 'success',
            'title' => __('messages.alerts.01'),
            'message' => __('messages.alerts.03')
        ]);
    }

    public function getUserNameData(Request $request)
    {
        $data = User::find($request->id);
        return response()->json([
            "status" => "Success",
            "content" => $data->getUserFullName()
        ]);
    }
}
