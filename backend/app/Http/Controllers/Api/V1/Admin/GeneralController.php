<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\General;
use App\Http\Resources\GeneralResource;
use Illuminate\Support\Facades\Storage;

class GeneralController extends Controller
{
    // Lấy thông tin chung
    public function index()
    {
        $general = General::find(1);  // Trả về một bản ghi duy nhất
        return new GeneralResource($general);  // Trả về resource đơn
    }

    // Tạo thông tin chung mới
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'logo' => 'nullable|string|max:255', // Đường dẫn logo có thể null
            'des_footer' => 'nullable|string', // Mô tả footer có thể null
        ]);

        try {
            // Tạo thông tin chung mới
            $general = General::create($validatedData);
            return new GeneralResource($general);
        } catch (\Exception $e) {
            return response()->json(['message' => 'General info could not be created: ' . $e->getMessage()], 500);
        }
    }

    // Lấy thông tin chung theo ID
    public function show($id)
    {
        $general = General::find($id);
        if ($general) {
            return new GeneralResource($general);
        } else {
            return response()->json(['message' => 'General info not found'], 404);
        }
    }

    // Cập nhật thông tin chung theo ID
    public function update(Request $request, $id)
    {
        $general = General::find($id);
        if (!$general) {
            return response()->json(['message' => 'General info not found'], 404);
        }

        $validatedData = $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'des_footer' => 'nullable|string',
        ]);

        try {
            // Handle logo file upload
            // if ($request->hasFile('logo')) {
            //     // Xóa logo hiện tại nếu có
            //     if ($general->logo && Storage::disk('public')->exists($general->logo)) {
            //         Storage::disk('public')->delete($general->logo);
            //     }

            //     // Lấy tên gốc của tệp logo và thay thế khoảng trắng bằng dấu gạch dưới
            //     $logoName = $request->file('logo')->getClientOriginalName();
            //     $logoName = str_replace(' ', '_', $logoName);  // Thay thế khoảng trắng bằng dấu gạch dưới

            //     // Lưu logo mới với tên đã xử lý
            //     $validatedData['logo'] = $request->file('logo')->storeAs('logos', $logoName, 'public');
            // }
            if ($request->hasFile('logo')) {
                // Xóa file cũ nếu có
                if ($general->logo) {
                    Storage::delete($general->logo);
                }
                // Lưu file mới
                $validatedData['logo'] = $request->file('logo')->store('logos', 'public');
            }
            // Update general information
            $general->update($validatedData);
            return new GeneralResource($general);
        } catch (\Exception $e) {
            return response()->json(['message' => 'General info could not be updated: ' . $e->getMessage()], 500);
        }
    }

    // Xóa thông tin chung theo ID
    public function destroy($id)
    {
        $general = General::find($id);
        if ($general) {
            try {
                // Xóa thông tin chung
                $general->delete();
                return response()->json(['message' => 'General info deleted successfully'], 204);
            } catch (\Exception $e) {
                return response()->json(['message' => 'General info could not be deleted: ' . $e->getMessage()], 500);
            }
        } else {
            return response()->json(['message' => 'General info not found'], 404);
        }
    }
}
