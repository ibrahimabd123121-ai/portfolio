<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Technology;
use App\Http\Resources\TechnologyResource;

class TechnologyController extends Controller
{
    public function index()
    {
        $technologies = Technology::orderBy('name')->get();
        return TechnologyResource::collection($technologies);
    }
}
