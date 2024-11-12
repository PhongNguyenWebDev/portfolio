<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\IconResource;
use App\Models\Icon;

class IconController extends Controller
{
    public function index()
    {
        $icons = Icon::all();
        return IconResource::collection($icons);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url',
            'class_name' => 'required', // Allow only png and svg
        ]);

        try {
            // Create a new icon
            $icon = Icon::create($validatedData);
            return new IconResource($icon);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Icon could not be created: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $icon = Icon::find($id);
        if ($icon) {
            return new IconResource($icon);
        } else {
            return response()->json(['message' => 'Icon not found'], 404);
        }
    }
    public function update(Request $request, $id)
    {
        $icon = Icon::find($id);
        if ($icon) {
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'url' => 'required|url',
                'class_name' => 'required', // Allow only png and svg
            ]);

            try {
                // Update the icon
                $icon->update($validatedData);
                return new IconResource($icon);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Icon could not be updated: ' . $e->getMessage()], 500);
            }
        } else {
            return response()->json(['message' => 'Icon not found'], 404);
        }
    }
    public function destroy($id)
    {
        $icon = Icon::find($id);
        if ($icon) {
            try {
                // Delete the icon
                $icon->delete();
                return response()->json(['message' => 'Icon deleted successfully'], 204);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Icon could not be deleted: ' . $e->getMessage()], 500);
            }
        } else {
            return response()->json(['message' => 'Icon not found'], 404);
        }
    }
}
