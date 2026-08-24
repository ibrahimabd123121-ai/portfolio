<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectAdminController extends Controller
{
    public function index()
    {
        $projects = Project::with('technologies')->orderBy('sort_order')->get();

        return ProjectResource::collection($projects);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:projects,slug',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'github_url' => 'nullable|url',
            'live_url' => 'nullable|url',
            'is_featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'technology_ids' => 'nullable|array',
            'technology_ids.*' => 'integer|exists:technologies,id',
        ]);

        $project = Project::create($data);

        if (!empty($data['technology_ids'])) {
            $project->technologies()->sync($data['technology_ids']);
        }

        return new ProjectResource($project->load('technologies'));
    }

    public function show(Project $project)
    {
        return new ProjectResource($project->load('technologies'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|nullable|string|max:255|unique:projects,slug,' . $project->id,
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'github_url' => 'nullable|url',
            'live_url' => 'nullable|url',
            'is_featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'technology_ids' => 'nullable|array',
            'technology_ids.*' => 'integer|exists:technologies,id',
        ]);

        $project->update($data);

        if (array_key_exists('technology_ids', $data)) {
            $project->technologies()->sync($data['technology_ids'] ?? []);
        }

        return new ProjectResource($project->load('technologies'));
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return response()->json(['message' => 'Project deleted successfully']);
    }
}
