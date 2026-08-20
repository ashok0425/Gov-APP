<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Storage;

/**
 * Picks a picture for seeded records out of whatever is already sitting in
 * storage/app/public/uploads. A demo database looks like nothing at all when
 * every tile falls back to the grey placeholder, and shipping sample images
 * with the repo would only bloat it.
 *
 * Handing out images round-robin keeps the same seed reproducible: run the
 * seeder twice and every record keeps the picture it had.
 */
class DemoImage
{
    /** @var array<int, string>|null */
    protected static $pool;

    protected static $cursor = 0;

    /** Start the round-robin over, so each seeder gets the same sequence. */
    public static function rewind()
    {
        static::$cursor = 0;
    }

    /**
     * The next image path, relative to the public disk — the form the blades
     * expect, since they render asset('storage/'.$path). Null when the uploads
     * folder is empty, which the blades already handle with a placeholder.
     */
    public static function next()
    {
        $pool = static::pool();

        if (empty($pool)) {
            return null;
        }

        return $pool[static::$cursor++ % count($pool)];
    }

    protected static function pool()
    {
        if (static::$pool !== null) {
            return static::$pool;
        }

        $disk = Storage::disk('public');

        if (! $disk->exists('uploads')) {
            return static::$pool = [];
        }

        $images = collect($disk->files('uploads'))
            ->filter(fn ($path) => in_array(
                strtolower(pathinfo($path, PATHINFO_EXTENSION)),
                ['jpg', 'jpeg', 'png', 'webp'],
            ))
            // files() has no guaranteed order across filesystems; sorting does.
            ->sort()
            ->values()
            ->all();

        return static::$pool = $images;
    }
}
