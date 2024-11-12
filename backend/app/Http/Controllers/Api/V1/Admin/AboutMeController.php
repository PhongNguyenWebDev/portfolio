<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\AboutMeResource;
use App\Models\AboutMe;

class AboutMeController extends Controller
{
    public function index()
    {
        $aboutMe = AboutMe::all();
        if (!$aboutMe) {
            return response()->json(['error' => 'About Me not found'], 404);
        }
        return response()->json(['data' => $aboutMe]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:225',
            'description' => 'required|string',
        ]);
        $aboutMe = AboutMe::create($validatedData);
        return response()->json(new AboutMeResource($aboutMe));
    }

    public function show($id)
    {
        $aboutMe = AboutMe::find($id);
        if (!$aboutMe) {
            return response()->json(['error' => 'About Me not found'], 404);
        }
        return new AboutMeResource($aboutMe);
    }

    public function update(Request $request, $id)
    {
        $aboutMe = AboutMe::find($id);
        if (!$aboutMe) {
            return response()->json(['error' => 'About Me not found'], 404);
        }
        $validatedData = $request->validate([
            'title' => 'required|string|max:225',
            'description' => 'required|string',
        ]);
        $aboutMe->update($validatedData);
        return response()->json(new AboutMeResource($aboutMe));
    }

    public function destroy($id)
    {
        $aboutMe = AboutMe::find($id);
        if (!$aboutMe) {
            return response()->json(['error' => 'About Me not found'], 404);
        }
        $aboutMe->delete();
        return response()->json(['message' => 'About Me deleted successfully']);
    }
}
