<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WorkEx;

class WorkExController extends Controller
{
    // Lấy danh sách tất cả Work Experience
    public function index()
    {
        $workEx = WorkEx::all();
        if ($workEx->isEmpty()) {
            return response()->json(['error' => 'No Work Experience found'], 404);
        }
        return response()->json(['data' => $workEx]);
    }

    // Tạo mới một Work Experience
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:150',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'gpa' => 'nullable|numeric|between:0,10',
            'gpa_scale' => 'nullable|numeric|between:0,10',
            'position' => 'required|string|max:100',
        ]);

        $workEx = WorkEx::create($validatedData);
        return response()->json(['data' => $workEx]);
    }

    // Lấy chi tiết một Work Experience theo ID
    public function show($id)
    {
        $workEx = WorkEx::find($id);
        if (!$workEx) {
            return response()->json(['error' => 'Work Experience not found'], 404);
        }
        return response()->json(['data' => $workEx]);
    }

    // Cập nhật Work Experience theo ID
    public function update(Request $request, $id)
    {
        $workEx = WorkEx::find($id);
        if (!$workEx) {
            return response()->json(['error' => 'Work Experience not found'], 404);
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:150',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'gpa' => 'nullable|numeric|between:0,10',
            'gpa_scale' => 'nullable|numeric|between:0,10',
            'position' => 'required|string|max:100',
        ]);

        $workEx->update($validatedData);
        return response()->json(['data' => $workEx]);
    }

    // Xóa một Work Experience theo ID
    public function destroy($id)
    {
        $workEx = WorkEx::find($id);
        if (!$workEx) {
            return response()->json(['error' => 'Work Experience not found'], 404);
        }

        $workEx->delete();
        return response()->json(['message' => 'Work Experience deleted successfully']);
    }
}
