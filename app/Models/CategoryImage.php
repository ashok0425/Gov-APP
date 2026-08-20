<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * One slide of a category's cover carousel. The column is called thumbnail
 * so the mobile carousel partial can pluck it exactly like a banner row.
 */
class CategoryImage extends Model
{
    protected $fillable = [
        'category_id',
        'thumbnail',
        'position',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
