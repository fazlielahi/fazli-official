<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CvTrashSettingsController extends Controller
{
    public function edit(Request $request)
    {
        $user = Auth::user();
        $days = SiteSetting::getCvTrashRetentionDays();

        return view('admin.cv-trash-settings.edit', compact('user', 'days'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'trash_retention_days' => 'required|integer|min:1|max:365',
        ]);

        SiteSetting::setCvTrashRetentionDays((int) $validated['trash_retention_days']);

        return redirect()
            ->route('localized.admin.cv-trash-settings.edit', ['lang' => $request->route('lang')])
            ->with('success', 'Trash retention updated.');
    }
}
