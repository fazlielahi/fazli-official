<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiteSettingsController extends Controller
{
    public function edit(Request $request)
    {
        $user = Auth::user();
        if ($user->type !== 'super_admin') {
            abort(403);
        }

        $settings = SiteSetting::allForAdmin();

        return view('admin.settings.edit', compact('user', 'settings'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        if ($user->type !== 'super_admin') {
            abort(403);
        }

        $validated = $request->validate([
            'session_lifetime_minutes' => 'required|integer|min:5|max:10080',
            'remember_me_days' => 'required|integer|min:1|max:365',
            'session_expire_on_close' => 'nullable|boolean',
            'trash_retention_days' => 'required|integer|min:1|max:365',
        ]);

        SiteSetting::setSessionLifetimeMinutes((int) $validated['session_lifetime_minutes']);
        SiteSetting::setRememberMeDays((int) $validated['remember_me_days']);
        SiteSetting::setSessionExpireOnClose($request->boolean('session_expire_on_close'));
        SiteSetting::setCvTrashRetentionDays((int) $validated['trash_retention_days']);

        return redirect()
            ->route('localized.admin.settings.edit', ['lang' => $request->route('lang')])
            ->with('success', __('lang.ADMIN_SETTINGS_SAVED'));
    }
}
