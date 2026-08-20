<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Organizations, the level above the menu tree: the app's home shows them
 * first, and every main category is filed under one.
 */
class OrganizationController extends Controller
{
    public function index(Request $request)
    {
        $organizations = Organization::withCount([
                'categories as main_categories_count' => fn ($q) => $q->whereNull('parent_id'),
            ])
            ->when($request->keyword, function ($query) use ($request) {
                $query->where('name', 'LIKE', '%'.$request->keyword.'%');
            })
            ->ordered()
            ->paginate(15)
            ->withQueryString();

        return view('organization.index', compact('organizations'));
    }

    public function create()
    {
        return view('organization.create');
    }

    public function store(Request $request)
    {
        $request->validate($this->rules());

        $organization = new Organization;
        $organization->name = $request->name;
        $organization->thumbnail = $request->file('thumbnail')?->store('uploads/organization', 'public');
        $organization->top_image = $request->file('top_image')?->store('uploads/organization-tops', 'public');
        $organization->status = $request->status ?? 1;
        $organization->save();

        return redirect()->route('organizations.index')->with([
            'alert-type' => 'success',
            'message' => 'Organization Added',
        ]);
    }

    public function edit(Organization $organization)
    {
        return view('organization.edit', compact('organization'));
    }

    public function update(Request $request, Organization $organization)
    {
        $request->validate($this->rules($organization));

        $organization->name = $request->name;
        $organization->status = $request->status;

        if ($thumbnail = $request->file('thumbnail')?->store('uploads/organization', 'public')) {
            $organization->thumbnail = $thumbnail;
        }

        if ($request->boolean('remove_top_image')) {
            \Storage::disk('public')->delete((string) $organization->top_image);
            $organization->top_image = null;
        }

        if ($topImage = $request->file('top_image')?->store('uploads/organization-tops', 'public')) {
            $organization->top_image = $topImage;
        }

        $organization->save();

        return redirect()->route('organizations.index')->with([
            'alert-type' => 'success',
            'message' => 'Organization updated',
        ]);
    }

    public function destroy(Organization $organization)
    {
        // Its categories live on, just unassigned — the foreign key nulls
        // itself — so they can be moved to another organization rather than
        // vanishing with this one.
        $organization->delete();

        return redirect()->back()->with([
            'alert-type' => 'success',
            'message' => 'Organization Deleted',
        ]);
    }

    /** Drag-and-drop order from the list: positions follow the given ids. */
    public function reorder(Request $request)
    {
        $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer'],
            'start' => ['nullable', 'integer', 'min:0'],
        ]);

        $start = (int) $request->input('start', 0);

        foreach ($request->ids as $index => $id) {
            Organization::where('id', $id)->update(['position' => $start + $index]);
        }

        return response()->json(['ok' => true]);
    }

    protected function rules(?Organization $organization = null)
    {
        return [
            'name' => [
                'required',
                'max:255',
                Rule::unique('organizations', 'name')->ignore($organization?->id),
            ],
            'thumbnail' => ['nullable', 'image'],
            'top_image' => ['nullable', 'image'],
        ];
    }
}
