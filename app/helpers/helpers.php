<?php

use App\Models\Category;
use App\Models\Cms;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

if (! function_exists('getCategory')) {
    function getCategory()
    {
        $categories = Cache::remember('categories', 86400, function () {
            return Category::latest()->get();
        });

        return $categories;
    }
}

if (! function_exists('cms')) {
    function cms($key = null)
    {
        // $cms = Cache::remember('cms', 86400, function () {
            return Cms::first();
        // });
        $r=$key ? $cms->$key : $cms;
        return $r;
    }
}


function getImage($image_file, $static = false)
{
    if ($static) {
        return asset($image_file);
    }

    if ($image_file) {
        return Storage::disk('local')->url($image_file);
    }

    return "https://via.placeholder.com/300x300";
}
