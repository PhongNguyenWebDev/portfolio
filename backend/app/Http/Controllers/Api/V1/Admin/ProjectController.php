<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Resources\ProjectResource;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    // Get all projects
    public function index()
    {
        $projects = Project::all();
        return ProjectResource::collection($projects);
    }

    // Create a new project
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:200',
            'image_project' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'image_tech' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'url' => 'nullable|url',
        ]);

        try {
            $validatedData['image_project'] = $request->hasFile('image_project')
                ? $request->file('image_project')->store('images', 'public')
                : null;

            $validatedData['image_tech'] = $request->hasFile('image_tech')
                ? $request->file('image_tech')->store('images', 'public')
                : null;

            $project = Project::create($validatedData);
            return new ProjectResource($project);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Project could not be created: ' . $e->getMessage()], 500);
        }
    }

    // Show a specific project by ID
    public function show($id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }
        return new ProjectResource($project);
    }

    // Update a project by ID
    public function update(Request $request, $id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:200',
            'image_project' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'image_tech' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'url' => 'nullable|url',
        ]);

        try {
            // Handle image_project file upload
            if ($request->hasFile('image_project')) {
                if ($project->image_project && Storage::disk('public')->exists($project->image_project)) {
                    Storage::disk('public')->delete($project->image_project);
                }
                $validatedData['image_project'] = $request->file('image_project')->store('images', 'public');
            }

            // Handle image_tech file upload
            if ($request->hasFile('image_tech')) {
                if ($project->image_tech && Storage::disk('public')->exists($project->image_tech)) {
                    Storage::disk('public')->delete($project->image_tech);
                }
                $validatedData['image_tech'] = $request->file('image_tech')->store('images', 'public');
            }

            $project->update($validatedData);

            return response()->json(['message' => 'Project updated successfully', 'project' => new ProjectResource($project)], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Project could not be updated: ' . $e->getMessage()], 500);
        }
    }

    // Delete a project by ID
    public function destroy($id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        try {
            if ($project->image_project) {
                Storage::disk('public')->delete($project->image_project);
            }
            if ($project->image_tech) {
                Storage::disk('public')->delete($project->image_tech);
            }

            $project->delete();
            return response()->json(['message' => 'Project deleted successfully'], 204);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Project could not be deleted: ' . $e->getMessage()], 500);
        }
    }
}
