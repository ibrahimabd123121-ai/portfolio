<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SkillResource;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillAdminController extends Controller
{
    public function index()
    {
        $skills = Skill::orderBy('sort_order')->get();

        return SkillResource::collection($skills);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'level' => 'nullable|string|max:255',
            'icon' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        $skill = Skill::create($data);

        return new SkillResource($skill);
    }

    public function show(Skill $skill)
    {
        return new SkillResource($skill);
    }

    public function update(Request $request, Skill $skill)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'category' => 'nullable|string|max:255',
            'level' => 'nullable|string|max:255',
            'icon' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        $skill->update($data);

        return new SkillResource($skill);
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();

        return response()->json(['message' => 'Skill deleted successfully']);
    }
}
