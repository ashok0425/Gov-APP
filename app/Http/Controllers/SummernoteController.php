<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SummernoteController extends Controller
{
    /**
     * Image upload endpoint for the CKEditor 5 SimpleUploadAdapter.
     * CKEditor posts the file as "upload" and expects {"url": "..."} back.
     */
    public function upload(Request $request)
    {
        $request->validate(['upload' => 'required|image|max:2048']);

        $file = $request->file('upload');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('uploads', $filename, 'public');

        return response()->json(['url' => asset('storage/' . $path)]);
    }
}
