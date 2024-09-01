<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Datatables;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Sistem Yöneticisi'],['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy']]);
    }

    public function index(Request $request)
    {
        $data = Permission::all();

        $totalPermissionCount = $data->count();
        $activePermissionCount = User::with('permissions')->get()->count();

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('linkedUserCount', function ($row_linkedUserCount) {
                    return User::permission($row_linkedUserCount->name)->get()->count();
                })
                ->make(true);
        }

        return view('pages.permissions.permissions_index', compact('totalPermissionCount', 'activePermissionCount'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('pages.permissions.permissions_create', compact('roles'));
    }

    public function store(PermissionRequest $request)
    {
        $permission = new Permission();
        $permission->name = $request['input-name'];
        $permission->description = $request['input-description'];
        $permission->created_by = Auth::user()->id;
        $permission->save();

        foreach ($request['input-role_selection'] as $item) {
            $role = Role::find($item);
            $role->givePermissionTo($request['input-name']);
        }

        return redirect()->route('Permissions.Index')
            ->with('result','success')
            ->with('title',__('messages.alerts.01'))
            ->with('content',__('messages.alerts.02'));
    }

    public function edit(string $id)
    {
        $permission = Permission::find($id);
        $roles = Role::all();
        return view('pages.permissions.permissions_edit', compact('permission', 'roles'));
    }

    public function update(PermissionRequest $request, string $id)
    {
        $roles = Role::all();

        $permission = Permission::find($id);
        $currentPermissionName = $permission->name;
        $permission->name = $request['input-name'];
        $permission->description = $request['input-description'];
        $permission->updated_by = Auth::user()->id;

        foreach ($roles as $role) {
            if($role->hasPermissionTo($currentPermissionName)) {
                $role->revokePermissionTo($currentPermissionName);
            }
        }

        $permission->save();

        foreach ($request['input-role_selection'] as $item) {
            $role = Role::find($item);
            $role->givePermissionTo($request['input-name']);
        }

        return redirect()->route('Permissions.Edit', $id)
            ->with('result','warning')
            ->with('title',__('messages.alerts.01'))
            ->with('content',__('messages.alerts.04'));
    }

    public function destroy(string $id)
    {
        $permission = Permission::find($id);

        $roles = Role::all();

        foreach ($roles as $role) {
            if($role->hasPermissionTo($permission->name)) {
                $role->revokePermissionTo($permission->name);
            }
        }

        $permission->update([
            'deleted_by' => Auth::user()->id
        ]);

        $permission->delete();

        return response()->json([
            'status' => 'success',
            'title' => __('messages.alerts.01'),
            'message' => __('messages.alerts.03')
        ]);
    }
}
