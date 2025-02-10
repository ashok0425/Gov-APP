<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;

    protected $fillable = [
        'meta_title',
        'meta_description',
        'meta_keyword',
        'url',
        'logo',
        'phone1',
        'phone2',
        'email1',
        'email2',
        'address',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
        'shipping_charge',
    ];
}
