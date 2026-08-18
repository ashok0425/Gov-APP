<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory;
    use SoftDeletes;

    // In your Eloquent model (e.g., Booking.php)
public function scopeAccessibleBy($query, $user)
{
    if ($user->can('do:anything')) {
        return $query;
    }

    if ($user->role == 2) {
        return $query;
    }

    if ($user->role==3) {
        return $query->where('business_id', $user->business_id);
    }

    return $query->where('user_id', $user->id);
}


    protected $fillable = [
        'thumbnail',
        'title',
        'short_description',
        'long_description',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($blog) {
            $blog->deleted_by = Auth::user()->id;
            $blog->save();
        });
    }

    public function business(){
        return $this->belongsTo(Business::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function subcategory(){
        return $this->belongsTo(Category::class, 'subcategory_id');
    }

    public function childCategory(){
        return $this->belongsTo(Category::class, 'child_category_id');
    }

    /**
     * Posts filed anywhere at or under the given category. A post records the
     * whole trail it was filed under, so matching any of the three columns
     * catches a category's own posts and everything beneath it.
     */
    public function scopeInCategory($query, $categoryId)
    {
        return $query->where(function ($q) use ($categoryId) {
            $q->where('category_id', $categoryId)
                ->orWhere('subcategory_id', $categoryId)
                ->orWhere('child_category_id', $categoryId);
        });
    }

}
