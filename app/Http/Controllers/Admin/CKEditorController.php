<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CKEditorController extends Controller
{
    public function uploadImage(Request $request)
    {
        //dd($request);
        //info($request);
        if($request->hasFile('upload')) //ck editor sends the file in upload
        {
            $request->validate([
                'upload' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            ]);

            //store in storage

            $path = $request->file('upload')->store('ckeditor', 'public');
            // info($path);
            // build the url to the stored file
            $url = asset('storage/' . $path);

            return response()->json([
                'uploaded' => 1,
                'filename' => basename($path),
                'url' => $url,
            ]);
        }

        // if upload failed
        return response()->json([
            'uploaded' => 0,
            'error' => ['message' => 'no file uploaded']
        ]);
    }
}
