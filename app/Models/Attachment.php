<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    /**
     * What this user may see: an employee pinned to part of the menu only
     * gets the attachments they uploaded themselves; everyone else sees all.
     */
    public function scopeAccessibleBy($query, $user)
    {
        if ($user->isPinned()) {
            $query->where('user_id', $user->id);
        }

        return $query;
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function business(){

        return $this->belongsTo(Business::class,'business_id');

    }
}
