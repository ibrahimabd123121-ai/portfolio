<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    public function technologies(): BelongsToMany
    {
        return $this->belongsToMany(Technology::class);
    }

    protected $fillable = [

            'title',
            'slug',
            'short_description',
            'description',
            'image',
            'github_url',
            'live_url',
            'is_featured',
            'sort_order'
    ];

   
}
