<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileAdminController extends Controller
{
    public function show()
    {
        $profile = Profile::first();

        if (!$profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        return new ProfileResource($profile);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'nullable|integer|exists:users,id',
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'location' => 'nullable|string',
            'profile_image' => 'nullable|string',
            'github_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'website_url' => 'nullable|url',
        ]);

        $profile = Profile::create($data);

        return new ProfileResource($profile);
    }

    public function update(Request $request)
    {
        $profile = Profile::first();

        if (!$profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        $data = $request->validate([
            'user_id' => 'nullable|integer|exists:users,id',
            'name' => 'sometimes|required|string|max:255',
            'title' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'location' => 'nullable|string',
            'profile_image' => 'nullable|string',
            'github_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'website_url' => 'nullable|url',
        ]);

        $profile->update($data);

        return new ProfileResource($profile);
    }
}
