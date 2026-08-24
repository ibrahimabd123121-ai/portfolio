<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\TechnologyResource;
use App\Models\Technology;
use Illuminate\Http\Request;

class TechnologyAdminController extends Controller
{
    public function index()
    {
        $technologies = Technology::orderBy('name')->get();

        return TechnologyResource::collection($technologies);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:technologies,slug',
            'icon' => 'nullable|string',
        ]);

        $technology = Technology::create($data);

        return new TechnologyResource($technology);
    }

    public function show(Technology $technology)
    {
        return new TechnologyResource($technology);
    }

    public function update(Request $request, Technology $technology)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|nullable|string|max:255|unique:technologies,slug,' . $technology->id,
            'icon' => 'nullable|string',
        ]);

        $technology->update($data);

        return new TechnologyResource($technology);
    }

    public function destroy(Technology $technology)
    {
        $technology->delete();

        return response()->json(['message' => 'Technology deleted successfully']);
    }
}
