<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\GeneralResource;
use App\Http\Resources\IconResource;
use App\Http\Resources\SkillResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\SliderResource;
use App\Http\Resources\AboutMeResource;
use App\Http\Resources\WorkExResource;

use App\Models\WorkEx;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Icon;
use App\Models\General;
use App\Models\Slider;
use App\Models\AboutMe;
use App\Models\User;

class FetchLayoutController extends Controller
{
    public function index()
    {
        $general = GeneralResource::collection(General::all());
        $icons = IconResource::collection(Icon::all());
        $skills = SkillResource::collection(Skill::all());
        $projects = ProjectResource::collection(Project::all());
        $sliders = SliderResource::collection(Slider::all());
        $aboutMe = AboutMeResource::collection(AboutMe::all());
        $workEx = WorkExResource::collection(WorkEx::all());
        $users = User::selectRaw('name, email, address, phone')->get();
        return response()->json([
            'general' => $general,
            'icons' => $icons,
            'skills' => $skills,
            'projects' => $projects,
            'sliders' => $sliders,
            'aboutMe' => $aboutMe,
            'workEx' => $workEx,
            'users' => $users,
        ]);
    }
}
