<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;


    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'business_id',
        'address',
       'role',
       'is_owner',
       'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];


    public function business(){
        return $this->belongsTo(Business::class);
    }

    /** The menu nodes this employee is pinned to. */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * The nodes this user is confined to — they may only see and file posts
     * at them and below them. Empty means unrestricted: super admins, and
     * anyone with nothing assigned.
     */
    public function scopedCategories()
    {
        if ($this->role == 1 || $this->can('do:anything')) {
            return collect();
        }

        return $this->categories;
    }

    /** Whether this user is confined to part of the menu. */
    public function isPinned()
    {
        return $this->scopedCategories()->isNotEmpty();
    }
}
