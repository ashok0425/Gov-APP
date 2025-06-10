<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
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


    public function blogs(){
        return $this->hasMany(Blog::class);
    }
}
