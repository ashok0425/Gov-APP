<?php

namespace App\Http\Controllers\API;


use App\Models\Business;
use App\Models\Category;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog;

class HomeController extends Controller
{
    public function wards()
    {
        $business = Business::latest()->paginate(25);
       return response()->json([
        'success'=>true,
        'data'=>$business
       ],200);
    }

    public function category()
    {
        $category = Category::latest()->paginate(25);
       return response()->json([
        'success'=>true,
        'data'=>$category
       ],200);
    }

    public function blogs()
    {
        $blog = Blog::latest()->where('status',1)->paginate(25);
       return response()->json([
        'success'=>true,
        'data'=>$blog
       ],200);
    }

    public function blogByWard($id)
    {
        $blog = Blog::latest()->where('status',1)->where('business_id',$id)->paginate(25);
       return response()->json([
        'success'=>true,
        'data'=>$blog
       ],200);
    }

    public function blogByCategory($id)
    {
        $blog = Blog::latest()->where('status',1)->where('category_id',$id)->paginate(25);
       return response()->json([
        'success'=>true,
        'data'=>$blog
       ],200);
    }

}
