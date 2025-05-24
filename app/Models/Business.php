<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $casts=[
        'category_ids'=>'array'
    ];

    public function categories(){
    return $this->belongsToMany(Category::class,'business_categories')->withPivot('position')->orderBy('pivot_position');
    }
}
