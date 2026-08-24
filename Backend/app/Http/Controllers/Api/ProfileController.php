<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Resources\ProfileResource;

class ProfileController extends Controller
{
    public function show()
    {
        $profile = Profile::firstOrFail();
        return new ProfileResource($profile);
    }
}
