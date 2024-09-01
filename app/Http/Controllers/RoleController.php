<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Http\Requests\RoleRequest;
use Datatables;
use App\Models\User;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Sistem Yöneticisi'],['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy']]);
    }

    public function index(Request $request)
    {
        $data = Role::all();

        $totalRoleCount = $data->count();
        $activeRoleCount = Role::with('permissions')->get()->count();

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('pages.roles.roles_index', compact('activeRoleCount', 'totalRoleCount'));
    }

    public function create()
    {
        return view('pages.roles.roles_create');
    }

    public function store(RoleRequest $request)
    {
        $role = new Role();
        $role->name = $request['input-name'];
        $role->description = $request['input-description'];
        $role->created_by = Auth::user()->id;
        $role->save();

        return redirect()->route('Roles.Index')
            ->with('result','success')
            ->with('title',__('messages.alerts.01'))
            ->with('content',__('messages.alerts.02'));
    }

    public function edit(string $id)
    {
        $role = Role::find($id);
        return view('pages.roles.roles_edit', compact('role'));
    }

    public function update(RoleRequest $request, string $id)
    {
        $role = Role::find($id);
        $role->name = $request['input-name'];
        $role->description = $request['input-description'];
        $role->updated_by = Auth::user()->id;
        $role->save();

        return redirect()->route('Roles.Edit', $id)
            ->with('result','warning')
            ->with('title',__('messages.alerts.01'))
            ->with('content',__('messages.alerts.04'));
    }

    public function destroy(string $id)
    {
        $role = Role::find($id);

        $role->update([
            'deleted_by' => Auth::user()->id
        ]);

        if (User::role($role->name)->get()->count() == 0 && count($role->permissions) == 0) {
            $role->delete();
            return response()->json([
                'status' => 'success',
                'title' => __('messages.alerts.01'),
                'message' => __('messages.alerts.03')
            ]);
        } else if(count($role->permissions) != 0) {
            return response()->json([
                'status' => 'aborted',
                'title' => __('messages.alerts.05'),
                'message' => __('messages.roles.alerts.02')
            ]);
        } else if(User::role($role->name)->get()->count() != 0) {
            return response()->json([
                'status' => 'aborted',
                'title' => __('messages.alerts.05'),
                'message' => __('messages.roles.alerts.01')
            ]);
        }
    }
}
