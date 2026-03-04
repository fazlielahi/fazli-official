<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class FounderController extends Controller
{
    // ============================================
    // EXPERIENCE METHODS
    // ============================================

    /**
     * Display a listing of experiences
     */
    public function experiencesIndex(Request $request)
    {
        $user = Auth::user();
        $experiences = Experience::ordered()->get();
        
        return view('admin.founder.experiences.index', compact('user', 'experiences'));
    }

    /**
     * Show the form for creating a new experience
     */
    public function experiencesCreate(Request $request)
    {
        $user = Auth::user();
        return view('admin.founder.experiences.create', compact('user'));
    }

    /**
     * Store a newly created experience
     */
    public function experiencesStore(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role_title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
            'location' => 'nullable|string|max:255',
            'employment_type' => 'required|in:Full-Time,Part-Time,Contract,Internship',
            'description' => 'nullable|string',
            'responsibilities' => 'nullable|array',
            'responsibilities.*' => 'string',
            'media_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'display_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = $request->except(['company_logo', 'media_images']);
        $data['is_current'] = $request->has('is_current');
        $data['is_active'] = $request->has('is_active') ? true : ($request->input('is_active', false));

        // Handle company logo upload
        if ($request->hasFile('company_logo')) {
            $logo = $request->file('company_logo');
            $logoName = time() . '_' . $logo->getClientOriginalName();
            $logoPath = $logo->storeAs('images/exp', $logoName, 'public');
            $data['company_logo'] = $logoPath;
        }

        // Handle media images upload
        if ($request->hasFile('media_images')) {
            $mediaPaths = [];
            foreach ($request->file('media_images') as $image) {
                $imageName = time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('images/experience-media', $imageName, 'public');
                $mediaPaths[] = $imagePath;
            }
            $data['media_images'] = $mediaPaths;
        }

        Experience::create($data);

        return redirect()->route('localized.admin.founder.experiences.index', ['lang' => app()->getLocale()])
            ->with('success', 'Experience added successfully!');
    }

    /**
     * Show the form for editing an experience
     */
    public function experiencesEdit(Request $request, $lang, $id)
    {
        $user = Auth::user();
        $experience = Experience::findOrFail($id);
        
        return view('admin.founder.experiences.edit', compact('user', 'experience'));
    }

    /**
     * Update an experience
     */
    public function experiencesUpdate(Request $request, $lang, $id)
    {
        $experience = Experience::findOrFail($id);

        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role_title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
            'location' => 'nullable|string|max:255',
            'employment_type' => 'required|in:Full-Time,Part-Time,Contract,Internship',
            'description' => 'nullable|string',
            'responsibilities' => 'nullable|array',
            'responsibilities.*' => 'string',
            'media_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'display_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = $request->except(['company_logo', 'media_images', '_method', '_token']);
        $data['is_current'] = $request->has('is_current');
        $data['is_active'] = $request->has('is_active') ? true : ($request->input('is_active', false));

        // Handle company logo upload
        if ($request->hasFile('company_logo')) {
            // Delete old logo
            if ($experience->company_logo && Storage::disk('public')->exists($experience->company_logo)) {
                Storage::disk('public')->delete($experience->company_logo);
            }
            
            $logo = $request->file('company_logo');
            $logoName = time() . '_' . $logo->getClientOriginalName();
            $logoPath = $logo->storeAs('images/exp', $logoName, 'public');
            $data['company_logo'] = $logoPath;
        }

        // Handle media images upload
        if ($request->hasFile('media_images')) {
            $existingMedia = $experience->media_images ?? [];
            // Keep existing media if provided
            if ($request->has('existing_media')) {
                $existingMedia = $request->input('existing_media', []);
            }
            
            $newMediaPaths = [];
            foreach ($request->file('media_images') as $image) {
                $imageName = time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('images/experience-media', $imageName, 'public');
                $newMediaPaths[] = $imagePath;
            }
            
            $data['media_images'] = array_merge($existingMedia, $newMediaPaths);
        } else if ($request->has('existing_media')) {
            // Update existing media array if no new files uploaded
            $data['media_images'] = $request->input('existing_media', []);
        }

        $experience->update($data);

        return redirect()->route('localized.admin.founder.experiences.index', ['lang' => app()->getLocale()])
            ->with('success', 'Experience updated successfully!');
    }

    /**
     * Remove an experience
     */
    public function experiencesDestroy(Request $request, $lang, $id)
    {
        $experience = Experience::findOrFail($id);
        
        // Delete associated files
        if ($experience->company_logo && Storage::disk('public')->exists($experience->company_logo)) {
            Storage::disk('public')->delete($experience->company_logo);
        }
        
        if ($experience->media_images) {
            foreach ($experience->media_images as $imagePath) {
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }
        }
        
        $experience->delete();

        return redirect()->route('localized.admin.founder.experiences.index', ['lang' => app()->getLocale()])
            ->with('success', 'Experience deleted successfully!');
    }

    /**
     * Remove a media image from experience
     */
    public function experiencesRemoveMedia(Request $request, $lang, $id)
    {
        $experience = Experience::findOrFail($id);
        $imagePath = $request->input('image_path');
        
        if ($experience->media_images && in_array($imagePath, $experience->media_images)) {
            // Delete file
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            
            // Remove from array
            $mediaImages = $experience->media_images;
            $mediaImages = array_values(array_filter($mediaImages, function($path) use ($imagePath) {
                return $path !== $imagePath;
            }));
            
            $experience->update(['media_images' => $mediaImages]);
            
            return response()->json(['success' => true, 'message' => 'Image removed successfully']);
        }
        
        return response()->json(['success' => false, 'message' => 'Image not found'], 404);
    }

    // ============================================
    // SKILLS METHODS
    // ============================================

    /**
     * Display a listing of skills
     */
    public function skillsIndex(Request $request)
    {
        $user = Auth::user();
        // TODO: Implement skills listing
        $skills = []; // Placeholder
        
        return view('admin.founder.skills.index', compact('user', 'skills'));
    }

    /**
     * Show the form for creating a new skill
     */
    public function skillsCreate(Request $request)
    {
        $user = Auth::user();
        return view('admin.founder.skills.create', compact('user'));
    }

    /**
     * Store a newly created skill
     */
    public function skillsStore(Request $request)
    {
        // TODO: Implement skill creation
        return redirect()->route('localized.admin.founder.skills.index', ['lang' => app()->getLocale()])
            ->with('success', 'Skill added successfully!');
    }

    /**
     * Show the form for editing a skill
     */
    public function skillsEdit(Request $request, $lang, $id)
    {
        $user = Auth::user();
        // TODO: Implement skill editing
        return view('admin.founder.skills.edit', compact('user'));
    }

    /**
     * Update a skill
     */
    public function skillsUpdate(Request $request, $lang, $id)
    {
        // TODO: Implement skill update
        return redirect()->route('localized.admin.founder.skills.index', ['lang' => app()->getLocale()])
            ->with('success', 'Skill updated successfully!');
    }

    /**
     * Remove a skill
     */
    public function skillsDestroy(Request $request, $lang, $id)
    {
        // TODO: Implement skill deletion
        return redirect()->route('localized.admin.founder.skills.index', ['lang' => app()->getLocale()])
            ->with('success', 'Skill deleted successfully!');
    }
}
