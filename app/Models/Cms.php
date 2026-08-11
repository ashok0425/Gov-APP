<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cms extends Model
{
    use HasFactory;

    /** The single settings row, read once per request however often it's asked for. */
    protected static $settings;

    public static function settings()
    {
        return static::$settings ??= static::first();
    }
}
