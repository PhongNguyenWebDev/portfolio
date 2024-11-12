<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skill;
use App\Http\Resources\SkillResource;

class SkillController extends Controller
{
    // Lấy danh sách tất cả các skills
    public function index()
    {
        $skills = Skill::all();
        return SkillResource::collection($skills);
    }

    // Tạo mới một skill
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:150',
            'process' => 'required|integer|min:0|max:100', // Giới hạn process từ 0 - 100
            'level' => 'required|in:basic,medium,advanced',
        ]);

        try {
            // Tạo một skill mới
            $skill = Skill::create($validatedData);
            return new SkillResource($skill);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Skill could not be created: ' . $e->getMessage()], 500);
        }
    }

    // Lấy chi tiết một skill theo ID
    public function show($id)
    {
        $skill = Skill::find($id);
        if ($skill) {
            return new SkillResource($skill);
        } else {
            return response()->json(['message' => 'Skill not found'], 404);
        }
    }

    // Cập nhật thông tin một skill theo ID
    public function update(Request $request, $id)
    {
        $skill = Skill::find($id);
        if ($skill) {
            // Validate the request data
            $validatedData = $request->validate([
                'title' => 'required|string|max:150',
                'process' => 'required|integer|min:0|max:100',
                'level' => 'required|in:basic,medium,advanced',
            ]);

            try {
                // Cập nhật skill
                $skill->update($validatedData);
                return new SkillResource($skill);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Skill could not be updated: ' . $e->getMessage()], 500);
            }
        } else {
            return response()->json(['message' => 'Skill not found'], 404);
        }
    }

    // Xóa một skill theo ID
    public function destroy($id)
    {
        $skill = Skill::find($id);
        if ($skill) {
            try {
                // Xóa skill
                $skill->delete();
                return response()->json(['message' => 'Skill deleted successfully'], 204);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Skill could not be deleted: ' . $e->getMessage()], 500);
            }
        } else {
            return response()->json(['message' => 'Skill not found'], 404);
        }
    }
}
