<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Şirket Yöneticisi'],['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy']]);
    }

    public function index(Request $request)
    {
        $data = Employee::where('client_id', Auth::user()->linkedClient->id)->get();
        $dataActiveCount = Employee::where('client_id', Auth::user()->linkedClient->id)->get();
        $data = Employee::where('client_id', Auth::user()->linkedClient->id)->get();

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('userFullName', function ($row_userFullName) {
                    return $row_userFullName->linkedUser->getUserFullName();
                })
                ->addColumn('userEmail', function ($row_userEmail) {
                    return $row_userEmail->linkedUser->email;
                })
                ->addColumn('userExtension', function ($row_userExtension) {
                    $extension_no = $row_userExtension->extension_no;
                    if ($extension_no == "0") {
                        return __('messages.employees.form.01.01');
                    } else {
                        return $row_userExtension->extension_no;
                    }
                })
                ->addColumn('userStatus', function ($row_userStatus) {
                    return ($row_userStatus->linkedUser->is_active) ? '<span class="badge rounded-pill badge-light-success">'.__('messages.users.form.05.01').'</span>' : '<span class="badge rounded-pill badge-light-danger">'.__('messages.users.form.05.02').'</span>';
                })
                ->rawColumns(['userStatus'])
                ->make(true);
        }

        return view('pages.employees.employees_index');
    }

    public function create()
    {
        $employees = Employee::where('client_id', Auth::user()->linkedClient->id)->get();
        $emptyExtensions = (new AsteriskManagementController())->getEmptyExtensions();
        return view('pages.employees.employees_create', compact('employees', 'emptyExtensions'));
    }

    public function store(EmployeeRequest $request)
    {
        $password = '';

        for($i = 0; $i < 8; $i++) {
            $password .= mt_rand(0, 9);
        }

        $extension_no = $request['input-extension_no'];
        if ($request['input-extension_no'] == "0") {
            $extension_no = "0";
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
        $user->client_id = Auth::user()->linkedClient->id;
        $user->user_type = 4;
        $user->save();

        $employee = new Employee();
        $employee->user_id = $user->id;
        $employee->client_id = Auth::user()->linkedClient->id;
        $employee->extension_no = $extension_no;
        $employee->show_numbers = $request['input-show_numbers'];
        $employee->created_by = Auth::user()->id;
        $employee->save();

        $user->assignRole("Şirket Kullanıcısı");

        return redirect()->route('Employees.Index')
            ->with('result','success')
            ->with('title',__('messages.alerts.01'))
            ->with('content',__('messages.alerts.02'));
    }

    public function edit(string $id)
    {
        $employee = Employee::find($id);
        $emptyExtensions = (new AsteriskManagementController())->getEmptyExtensions();
        return view('pages.employees.employees_edit', compact('employee', 'emptyExtensions'));
    }

    public function update(EmployeeRequest   $request, string $id)
    {
        $extension_no = $request['input-extension_no'];
        if ($request['input-extension_no'] == "0") {
            $extension_no = "0";
        }

        $employee = Employee::find($id);
        $employee->extension_no = $extension_no;
        $employee->show_numbers = $request['input-show_numbers'];
        $employee->updated_by = Auth::user()->id;
        $employee->save();

        $user = User::find($employee->user_id);
        $user->first_name = $request['input-first_name'];
        $user->last_name = $request['input-last_name'];
        $user->is_active = $request['input-is_active'];
        $user->updated_by = Auth::user()->id;
        $user->save();

        return redirect()->route('Employees.Edit', $id)
            ->with('result','warning')
            ->with('title',__('messages.alerts.01'))
            ->with('content',__('messages.alerts.04'));
    }

    public function destroy(string $id)
    {
        $employee = Employee::find($id);
        $user = User::find($employee->user_id);

        $employee->update([
            'is_active' => false,
            'deleted_by' => Auth::user()->id
        ]);

        $user->update([
            'is_active' => false,
            'deleted_by' => Auth::user()->id
        ]);

        $employee->delete();
        $user->delete();

        return response()->json([
            'status' => 'success',
            'title' => __('messages.alerts.01'),
            'message' => __('messages.alerts.03')
        ]);
    }
}
