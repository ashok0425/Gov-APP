<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SummernoteController extends Controller
{
    public function upload(Request $request)
{
    $request->validate(['file' => 'required|image|max:2048']);
    $file = $request->file('file');
    $filename = time().'_'.$file->getClientOriginalName();
    $path = $file->storeAs('uploads', $filename, 'public');
    return asset('storage/'.$path);
}
}
