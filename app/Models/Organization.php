<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * One organization: the app's home grid shows these first, and each holds
 * its own branch of the menu — the main categories assigned to it.
 */
class Organization extends Model
{
    protected $fillable = [
        'name',
        'thumbnail',
        'status',
        'position',
    ];

    /** Grid order: whatever position the admin gave, then alphabetical. */
    public function scopeOrdered($query)
    {
        return $query->orderBy('position')->orderBy('name');
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    /** The main categories under this organization — its menu grid. */
    public function mainCategories()
    {
        return $this->categories()->whereNull('parent_id')->ordered();
    }
}
