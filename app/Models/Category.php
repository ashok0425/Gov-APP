<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'thumbnail',
        'status',
    ];

    public function scopeAccessibleBy($query, $user)
{
    if ($user->role == 2||$user->role == 1) {
        return $query->where('status',1);
    }
        return $query->where('status',1)->whereIn('id', $user->business->categories()->get()->pluck('id')->toArray());

}

    /** Top-level categories — the ones a palika's "See More Menu" lists. */
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('name');
    }

    public function blogs(){
        return $this->hasMany(Blog::class);
    }
}
