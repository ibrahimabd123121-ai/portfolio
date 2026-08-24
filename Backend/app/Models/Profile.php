<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Profile extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(user::class);
    }

    protected $fillable = [
        'user_id',
        'name',
        'title',
        'bio',
        'email',
        'phone',
        'location',
        'profile_image',
        'github_url',
        'linkedin_url',
        'website_url'
    ];
}
