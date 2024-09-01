<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnnouncementRequest;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Datatables;

class AnnouncementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Sistem Yöneticisi|Sistem Kullanıcısı|Şirket Yöneticisi'],['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy']]);
    }

    public function index(Request $request)
    {
        $data = Announcement::where('created_by', Auth::user()->id)->get();

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('announcementStatus', function ($row_announcementStatus) {
                    return ($row_announcementStatus->is_active) ? '<span class="badge rounded-pill badge-light-success">'.__('messages.users.form.05.01').'</span>' : '<span class="badge rounded-pill badge-light-danger">'.__('messages.users.form.05.02').'</span>';
                })
                ->rawColumns(['announcementStatus'])
                ->make(true);
        }

        return view('pages.announcements.announcements_index');
    }

    public function create()
    {
        return view('pages.announcements.announcements_create');
    }

    public function store(AnnouncementRequest $request)
    {
        $Announcement = new Announcement();
        $Announcement->announcement_content = $request['input-announcement_content'];
        $Announcement->is_active = $request['input-is_active'];
        $Announcement->created_by = Auth::user()->id;
        $Announcement->save();

        return redirect()->route('Announcements.Index')
            ->with('result','success')
            ->with('title',__('messages.alerts.01'))
            ->with('content',__('messages.alerts.02'));
    }

    public function edit(string $id)
    {
        $announcement = Announcement::find($id);
        return view('pages.announcements.announcements_edit', compact('announcement'));
    }

    public function update(AnnouncementRequest $request, string $id)
    {
        $Announcement = Announcement::find($id);
        $Announcement->announcement_content = $request['input-announcement_content'];
        $Announcement->is_active = $request['input-is_active'];
        $Announcement->updated_by = Auth::user()->id;
        $Announcement->save();

        return redirect()->route('Announcements.Edit', $id)
            ->with('result','warning')
            ->with('title',__('messages.alerts.01'))
            ->with('content',__('messages.alerts.04'));
    }

    public function destroy(string $id)
    {
        $Announcement = Announcement::find($id);

        $Announcement->update([
            'is_active' => false,
            'deleted_by' => Auth::user()->id
        ]);

        $Announcement->delete();

        return response()->json([
            'status' => 'success',
            'title' => __('messages.alerts.01'),
            'message' => __('messages.alerts.03')
        ]);
    }

    public function myAnnouncements()
    {
        if (Auth::user()->user_type == 4 || Auth::user()->user_type == 3) {
            $announcements = Announcement::where('created_by', Auth::user()->linkedClient->user_id)->where('is_active', true)->orderBy('id', 'desc')->get();
        } elseif (Auth::user()->user_type == 2 || Auth::user()->user_type == 1) {
            $announcements = Announcement::where('is_active', true)->get();
        }

        return view('pages.my_announcements.my_announcements_index', compact('announcements'));
    }
}
