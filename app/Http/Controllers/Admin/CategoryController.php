<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Blog;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        // Get authenticated user using Laravel Auth
        // Middleware ensures user is authenticated
        $user = Auth::user();
        $categories = \App\Models\Category::all();
        return view('admin.active-category', compact('user', 'categories'));
    }

    public function create(Request $request)
    {
        // Get authenticated user using Laravel Auth
        // Middleware ensures user is authenticated
        $user = Auth::user();
        return view('admin.create-category', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        
        \App\Models\Category::create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
        ]);
        return redirect()->route('localized.admin.categories.index', ['lang' => app()->getLocale()])->with('success', 'Category added successfully!');
    }

    public function edit(Request $request, $lang, $id)
    {
        // Middleware ensures user is authenticated
        $category = \App\Models\Category::findOrFail($id);
        return response()->json(['category' => $category]);
    }

    public function update(Request $request, $lang, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $category = \App\Models\Category::findOrFail($id);
        $category->update([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
        ]);
        return redirect()->route('localized.admin.categories.index', ['lang' => app()->getLocale()])->with('success', 'Category updated successfully!');
    }

    public function destroy(Request $request, $lang, $id)
    {
        $category = \App\Models\Category::findOrFail($id);
        $category->delete();
        return redirect()->route('localized.admin.categories.index', ['lang' => app()->getLocale()])->with('success', 'Category deleted successfully!');
    }
} 