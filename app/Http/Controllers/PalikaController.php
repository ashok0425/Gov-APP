<?php

namespace App\Http\Controllers;


use App\Models\Business;
use App\Models\Category;
use Auth;
use Illuminate\Http\Request;

/**
 * Palikas — what used to be called wards. There is no longer a single special
 * "Palika" row: every record here is a palika and the admin adds as many as
 * needed. The model/table keep the legacy "Business" name because blogs,
 * banners, attachments and users all reference it by business_id.
 */
class PalikaController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->can('palika:view')) {
            abort(403);
        }

        $palikas = Business::orderBy('business_order', 'asc')
            ->when($request->keyword, function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->keyword . '%');
            })
            ->paginate(10)
            ->withQueryString();

        return view('palika.index', compact('palikas'));
    }

    public function create()
    {
        if (!Auth::user()->can('palika:create')) {
            abort(403);
        }

        $categories = Category::parents()->get();

        return view('palika.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('palika:create')) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required|integer|unique:businesses,phone',
            'address' => 'required',
        ]);

        $palika = new Business();
        $palika->name = $request->name;
        $palika->phone = $request->phone;
        $palika->address = $request->address;
        $palika->email = $request->email;
        $palika->facebook = $request->facebook;
        $palika->whatsapp = $request->whatsapp;
        $palika->other = $request->other;
        $palika->category_ids = [];
        $palika->messanger = $request->messanger;
        // New palikas go to the end of the list rather than jumping to the top.
        $palika->business_order = (int) Business::max('business_order') + 1;
        $palika->status = $request->status;
        $palika->google_map_link = $request->google_map_link;
        $palika->owner_name = $request->owner_name;

        if ($request->hasFile('thumbnail')) {
            $palika->thumbnail = $request->file('thumbnail')->store('uploads', 'public');
        }

        if ($request->hasFile('cover_image')) {
            $palika->cover_image = $request->file('cover_image')->store('uploads', 'public');
        }

        $palika->save();

        $notification = [
            'alert-type' => 'success',
            'message' => 'Palika created',
        ];

        return redirect()->route('palika.index')->with($notification);
    }

    public function edit(Business $palika)
    {
        if (!Auth::user()->can('palika:edit')) {
            abort(403);
        }

        $categories = Category::parents()->get();

        return view('palika.edit', compact('palika', 'categories'));
    }

    public function update(Request $request, Business $palika)
    {
        if (!Auth::user()->can('palika:edit')) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required|integer',
            'address' => 'required',
        ]);

        $palika->name = $request->name;
        $palika->phone = $request->phone;
        $palika->address = $request->address;
        $palika->email = $request->email;
        $palika->facebook = $request->facebook;
        $palika->whatsapp = $request->whatsapp;
        $palika->status = $request->status;
        $palika->messanger = $request->messanger;
        $palika->google_map_link = $request->google_map_link;
        $palika->owner_name = $request->owner_name;
        $palika->other = $request->other;

        if ($request->hasFile('thumbnail')) {
            $palika->thumbnail = $request->file('thumbnail')->store('uploads', 'public');
        }

        if ($request->hasFile('cover_image')) {
            $palika->cover_image = $request->file('cover_image')->store('uploads', 'public');
        }

        $palika->save();

        $notification = [
            'alert-type' => 'success',
            'message' => 'Palika updated',
        ];

        return redirect()->back()->with($notification);
    }

    public function show() {}

    public function reorder()
    {
        if (!Auth::user()->can('palika:reorder')) {
            abort(403);
        }

        $palikas = Business::orderBy('business_order', 'asc')->paginate(10);

        return view('palika.drag', compact('palikas'));
    }

    public function reorderStore(Request $request)
    {
        if (!Auth::user()->can('palika:reorder')) {
            abort(403);
        }

        foreach ($request->order ?? [] as $order) {
            $palika = Business::find($order['id']);

            if ($palika) {
                $palika->business_order = $order['position'];
                $palika->save();
            }
        }
    }

    public function destroy(Business $palika)
    {
        if (!Auth::user()->can('palika:delete')) {
            abort(403);
        }

        $palika->delete();

        $notification = [
            'alert-type' => 'success',
            'message' => 'Palika deleted',
        ];

        return redirect()->back()->with($notification);
    }

    /** Assign the top-level categories a palika shows in "See More Menu". */
    public function editCategories($id)
    {
        if (!Auth::user()->can('palika:category')) {
            abort(403);
        }

        $palika = Business::findOrFail($id);
        $assignedCategories = $palika->categories()->whereNull('parent_id')->get();
        $assigned = $assignedCategories->pluck('id')->toArray();
        $allCategories = Category::parents()->get();

        return view('palika.edit-categories', compact('palika', 'assigned', 'allCategories', 'assignedCategories'));
    }

    public function updateCategories(Request $request, $id)
    {
        if (!Auth::user()->can('palika:category')) {
            abort(403);
        }

        $palika = Business::findOrFail($id);
        $ids = explode(',', $request->input('categories', ''));

        $syncData = [];
        foreach ($ids as $index => $categoryId) {
            if ($categoryId) {
                $syncData[$categoryId] = ['position' => $index + 1];
            }
        }
        $palika->categories()->sync($syncData);

        $notification = [
            'alert-type' => 'success',
            'message' => 'Category sync successfully',
        ];

        return redirect()->back()->with($notification);
    }
}
