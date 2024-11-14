<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Resources\ProjectResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
            'image_tech.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Mảng ảnh kỹ thuật
            'url' => 'nullable|url',
        ]);

        try {
            // Xử lý upload file cho `image_project`
            $validatedData['image_project'] = $request->hasFile('image_project')
                ? $request->file('image_project')->store('images', 'public')
                : null;

            // Xử lý upload nhiều file cho `image_tech`
            $uploadedFiles = [];
            if ($request->hasFile('image_tech')) {
                foreach ($request->file('image_tech') as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('multiple_images', $filename, 'public');
                    $uploadedFiles[] = $filePath;
                }
            }

            // Lưu đường dẫn các file `image_tech` dưới dạng JSON
            $validatedData['image_tech'] = json_encode($uploadedFiles);

            // Tạo mới project và lưu vào cơ sở dữ liệu
            $project = Project::create($validatedData);

            return new ProjectResource($project);
        } catch (\Exception $e) {
            Log::error('Error creating project: ' . $e->getMessage());
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
        // Lấy dự án cần cập nhật
        $project = Project::findOrFail($id);

        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'title' => 'required|string|max:200',
            'image_project' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'image_tech.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Mảng ảnh kỹ thuật
            'url' => 'nullable|url',
        ]);

        try {
            // Xử lý upload file cho `image_project`
            if ($request->hasFile('image_project')) {
                // Xóa file cũ nếu có
                if ($project->image_project) {
                    Storage::delete($project->image_project);
                }
                // Lưu file mới
                $validatedData['image_project'] = $request->file('image_project')->store('images', 'public');
            }

            // Xử lý upload nhiều file cho `image_tech`
            $uploadedFiles = [];
            if ($request->hasFile('image_tech')) {
                // Xóa các file cũ nếu có
                // $oldImages = json_decode($project->image_tech, true);
                // if ($oldImages) {
                //     foreach ($oldImages as $image) {
                //         Storage::delete($image);
                //     }
                // }
                // Lưu các file mới
                foreach ($request->file('image_tech') as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('multiple_images', $filename, 'public');
                    $uploadedFiles[] = $filePath;
                }
            } // Chỉ lưu mảng JSON nếu có ít nhất một file được tải lên
            if (count($uploadedFiles) > 0) {
                $validatedData['image_tech'] = json_encode($uploadedFiles);
            } else {
                $validatedData['image_tech'] = null; // Hoặc có thể để trống (null)
            }

            // Lưu đường dẫn các file `image_tech` dưới dạng JSON
            $validatedData['image_tech'] = json_encode($uploadedFiles);

            // Cập nhật dữ liệu dự án
            $project->update($validatedData);

            return new ProjectResource($project);
        } catch (\Exception $e) {
            Log::error('Error updating project: ' . $e->getMessage());
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
            // Xóa các tệp liên quan đến `image_project` và `image_tech`
            if ($project->image_project) {
                Storage::disk('public')->delete($project->image_project);
            }
            if ($project->image_tech) {
                $oldFiles = json_decode($project->image_tech, true);
                if (is_array($oldFiles)) {
                    foreach ($oldFiles as $oldFile) {
                        if (Storage::disk('public')->exists($oldFile)) {
                            Storage::disk('public')->delete($oldFile);
                        }
                    }
                }
            }

            // Xóa dự án
            $project->delete();
            return response()->json([
                'message' => 'Project deleted successfully',
                'deleted_project_id' => $project->id
            ], 204);
        } catch (\Exception $e) {
            Log::error('Error deleting project: ' . $e->getMessage());
            return response()->json(['message' => 'Project could not be deleted: ' . $e->getMessage()], 500);
        }
    }
}
