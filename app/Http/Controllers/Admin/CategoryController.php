<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Blog;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        // Check if the user is logged in: either session or cookie has 'user_id'
        if (!$request->session()->has('user_id') && !$request->cookie('user_id')) {
            return redirect()->route('localized.login', ['lang' => app()->getLocale()]);
        }

        $user = User::find($request->session()->get('user_id'));
        $categories = \App\Models\Category::all();
        return view('admin.active-category', compact('user', 'categories'));
    }

    public function create(Request $request)
    {
        // Check if the user is logged in: either session or cookie has 'user_id'
        if (!$request->session()->has('user_id') && !$request->cookie('user_id')) {
            return redirect()->route('localized.login', ['lang' => app()->getLocale()]);
        }
        $user = User::find($request->session()->get('user_id'));
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
        if (!$request->session()->has('user_id') && !$request->cookie('user_id')) {
            return redirect()->route('localized.login', ['lang' => app()->getLocale()]);
        }
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