<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ReturnsToList;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * The notifications the app's सूचना tab lists. Kept apart from posts on
 * purpose: a notice is a short message with a date, not an article.
 */
class NoticeController extends Controller
{
    use ReturnsToList;

    public function index()
    {
        if (! Auth::user()->can('notice:view')) {
            abort(403);
        }

        $notices = Notice::latestFirst()->paginate(20);

        return view('notice.index', compact('notices'));
    }

    public function create()
    {
        if (! Auth::user()->can('notice:create')) {
            abort(403);
        }

        return view('notice.create');
    }

    public function store(Request $request)
    {
        if (! Auth::user()->can('notice:create')) {
            abort(403);
        }

        $data = $this->validated($request);

        $notice = new Notice;
        $notice->fill($data);
        $notice->thumbnail = $request->file('thumbnail')?->store('uploads', 'public');
        $notice->save();

        return redirect()->route('notices.index')->with([
            'alert-type' => 'success',
            'message' => 'Notification added',
        ]);
    }

    public function edit(Notice $notice)
    {
        if (! Auth::user()->can('notice:edit')) {
            abort(403);
        }

        return view('notice.edit', compact('notice'));
    }

    public function update(Request $request, Notice $notice)
    {
        if (! Auth::user()->can('notice:edit')) {
            abort(403);
        }

        $data = $this->validated($request);

        $notice->fill($data);

        if ($request->boolean('remove_thumbnail')) {
            $this->forget($notice->thumbnail);
            $notice->thumbnail = null;
        }

        // Leaving the file field empty keeps the picture that is already there.
        if ($image = $request->file('thumbnail')?->store('uploads', 'public')) {
            $this->forget($notice->thumbnail);
            $notice->thumbnail = $image;
        }

        $notice->save();

        return redirect()->to($this->returnUrl($request, 'notices.index'))->with([
            'alert-type' => 'success',
            'message' => 'Notification updated',
        ]);
    }

    public function show(Notice $notice)
    {
        return redirect()->route('notices.edit', $notice);
    }

    public function destroy(Notice $notice)
    {
        if (! Auth::user()->can('notice:delete')) {
            abort(403);
        }

        $this->forget($notice->thumbnail);
        $notice->delete();

        return redirect()->route('notices.index')->with([
            'alert-type' => 'success',
            'message' => 'Notification deleted',
        ]);
    }

    /**
     * The form's fields. published_at is optional: blank means the notice
     * goes out the moment it is saved, which is what the date on the app
     * then shows.
     */
    protected function validated(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|url|max:255',
            'published_at' => 'nullable|date',
            'thumbnail' => 'nullable|image',
        ]);

        $data['status'] = $request->boolean('status');
        $data['published_at'] = $data['published_at'] ?? null;

        unset($data['thumbnail']);

        return $data;
    }

    /** Drops an image the notice no longer uses. */
    protected function forget($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
