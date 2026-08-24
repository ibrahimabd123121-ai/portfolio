<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Technology extends Model
{
    public function project():BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }

    protected $fillable = [
        'name',
        'slug',
        'icon',
    ];
}
