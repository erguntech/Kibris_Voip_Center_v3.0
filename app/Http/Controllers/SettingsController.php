<?php

namespace App\Http\Controllers;

use App\Http\Requests\SystemSettingsRequest;
use App\Http\Requests\GeneralSettingsRequest;
use App\Models\UserSetting;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Sistem Yöneticisi'],['only' => ['systemSettings', 'systemSettingsUpdate']]);
    }

    public function generalSettings()
    {
        $userSettings = UserSetting::where('user_id', Auth::user()->id)->first();
        return view('pages.settings.general_settings_index', compact('userSettings'));
    }

    public function generalSettingsUpdate(GeneralSettingsRequest $request)
    {
        $userSettings = UserSetting::where('user_id', Auth::user()->id)->first();
        $userSettings->app_auto_logout_duration = $request['input-auto_logout_duration'];
        $userSettings->save();

        return redirect()->route('GeneralSettings.Index')
            ->with('result','warning')
            ->with('title',__('messages.alerts.01'))
            ->with('content',__('messages.alerts.04'));
    }

    public function systemSettings()
    {
        return view('pages.settings.system_settings_index');
    }

    public function systemSettingsUpdate(SystemSettingsRequest $request)
    {
        settings()->set([
            'app_auto_suspend_days' => $request['input-auto_suspend_days'],
            'app_system_currency' => $request['input-system_currency'],
            'app_whatsapp_contact' => $request['input-whatsapp_contact'],
            'app_telegram_contact' => $request['input-telegram_contact'],
            'app_skype_contact' => $request['input-skype_contact']
        ]);

        return redirect()->route('SystemSettings.Index')
            ->with('result','warning')
            ->with('title',__('messages.alerts.01'))
            ->with('content',__('messages.alerts.04'));
    }
}
