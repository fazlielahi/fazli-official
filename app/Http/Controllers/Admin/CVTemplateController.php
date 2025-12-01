<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CvTemplate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CVTemplateController extends Controller
{
    /**
     * Display a listing of CV templates
     */
    public function index(Request $request)
    {
        // Check if the user is logged in
        if (!$request->session()->has('user_id') && !$request->cookie('user_id')) {
            return redirect()->route('localized.login', ['lang' => app()->getLocale()]);
        }

        $user = User::find($request->session()->get('user_id'));
        $templates = CvTemplate::orderBy('created_at', 'desc')->get();
        
        return view('admin.cv-templates.index', compact('user', 'templates'));
    }

    /**
     * Show the form for creating a new template
     */
    public function create(Request $request)
    {
        // Check if the user is logged in
        if (!$request->session()->has('user_id') && !$request->cookie('user_id')) {
            return redirect()->route('localized.login', ['lang' => app()->getLocale()]);
        }

        $user = User::find($request->session()->get('user_id'));
        
        // Get available template folders from filesystem
        $templatesPath = resource_path('views/cv/templates');
        $existingTemplates = [];
        if (File::exists($templatesPath)) {
            $folders = File::directories($templatesPath);
            foreach ($folders as $folder) {
                $existingTemplates[] = basename($folder);
            }
        }
        
        return view('admin.cv-templates.create', compact('user', 'existingTemplates'));
    }

    /**
     * Store a newly created template
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:cv_templates,slug',
            'description' => 'nullable|string',
            'preview_image' => 'nullable|image|mimes:webp,png,jpg,jpeg|max:2048',
            'config' => 'nullable|json',
            'is_active' => 'boolean',
        ]);

        // Handle preview image upload
        $previewPath = null;
        if ($request->hasFile('preview_image')) {
            $image = $request->file('preview_image');
            $imageName = $request->input('slug') . '-preview.' . $image->getClientOriginalExtension();
            $image->move(public_path('cv-templates/previews'), $imageName);
            $previewPath = 'cv-templates/previews/' . $imageName;
        }

        // Validate JSON config if provided
        $config = null;
        if ($request->has('config') && !empty($request->input('config'))) {
            $config = json_decode($request->input('config'), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->withErrors(['config' => 'Invalid JSON format'])->withInput();
            }
        }

        CvTemplate::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'description' => $request->input('description'),
            'preview_path' => $previewPath,
            'config' => $config,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('localized.admin.cv-templates.index', ['lang' => app()->getLocale()])
            ->with('success', 'CV Template created successfully!');
    }

    /**
     * Show the form for editing a template
     */
    public function edit(Request $request, $lang, CvTemplate $cvTemplate)
    {
        // Check if the user is logged in
        if (!$request->session()->has('user_id') && !$request->cookie('user_id')) {
            return redirect()->route('localized.login', ['lang' => app()->getLocale()]);
        }

        $user = User::find($request->session()->get('user_id'));
        
        return view('admin.cv-templates.edit', compact('user', 'cvTemplate'));
    }

    /**
     * Update the specified template
     */
    public function update(Request $request, $lang, CvTemplate $cvTemplate)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:cv_templates,slug,' . $cvTemplate->id,
            'description' => 'nullable|string',
            'preview_image' => 'nullable|image|mimes:webp,png,jpg,jpeg|max:2048',
            'config' => 'nullable|json',
            'is_active' => 'boolean',
        ]);

        // Handle preview image upload
        $previewPath = $cvTemplate->preview_path;
        if ($request->hasFile('preview_image')) {
            // Delete old image if exists
            if ($previewPath && File::exists(public_path($previewPath))) {
                File::delete(public_path($previewPath));
            }
            
            $image = $request->file('preview_image');
            $imageName = $request->input('slug') . '-preview.' . $image->getClientOriginalExtension();
            $image->move(public_path('cv-templates/previews'), $imageName);
            $previewPath = 'cv-templates/previews/' . $imageName;
        }

        // Validate JSON config if provided
        $config = $cvTemplate->config;
        if ($request->has('config') && !empty($request->input('config'))) {
            $config = json_decode($request->input('config'), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->withErrors(['config' => 'Invalid JSON format'])->withInput();
            }
        }

        $cvTemplate->update([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'description' => $request->input('description'),
            'preview_path' => $previewPath,
            'config' => $config,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('localized.admin.cv-templates.index', ['lang' => app()->getLocale()])
            ->with('success', 'CV Template updated successfully!');
    }

    /**
     * Remove the specified template
     */
    public function destroy(Request $request, $lang, CvTemplate $cvTemplate)
    {
        // Delete preview image if exists
        if ($cvTemplate->preview_path && File::exists(public_path($cvTemplate->preview_path))) {
            File::delete(public_path($cvTemplate->preview_path));
        }

        $cvTemplate->delete();

        return redirect()->route('localized.admin.cv-templates.index', ['lang' => app()->getLocale()])
            ->with('success', 'CV Template deleted successfully!');
    }

    /**
     * Toggle active status of template
     */
    public function toggleActive(Request $request, $lang, CvTemplate $cvTemplate)
    {
        $cvTemplate->update([
            'is_active' => !$cvTemplate->is_active
        ]);

        $status = $cvTemplate->is_active ? 'activated' : 'deactivated';
        
        return redirect()->route('localized.admin.cv-templates.index', ['lang' => app()->getLocale()])
            ->with('success', "CV Template {$status} successfully!");
    }
}

