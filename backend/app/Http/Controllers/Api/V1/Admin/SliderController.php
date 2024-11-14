<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Http\Resources\SliderResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SliderController extends Controller
{
    public function index()
    {
        $slider = Slider::find(1);  // Trả về một bản ghi duy nhất
        return new SliderResource($slider);  // Trả về resource đơn
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url_cv' => 'nullable|file|mimes:pdf|max:2048',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Xử lý hình ảnh
        if ($request->hasFile('image')) {
            $imageName = $request->file('image')->getClientOriginalName();
            $imageName = str_replace(' ', '_', $imageName);
            $imagePath = $request->file('image')->storeAs('images', $imageName, 'public');
            $validatedData['image'] = $imagePath;
        }

        // Xử lý CV PDF
        if ($request->hasFile('url_cv')) {
            $pdfName = $request->file('url_cv')->getClientOriginalName();
            $pdfPath = $request->file('url_cv')->storeAs('pdfs', $pdfName, 'public');
            $validatedData['url_cv'] = $pdfPath;
        }


        $slider = Slider::create($validatedData);
        return response()->json(new SliderResource($slider), 201);
    }

    public function show($id)
    {
        $slider = Slider::find($id);
        if ($slider) {
            return new SliderResource($slider);
        } else {
            return response()->json(['message' => 'Slider not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        // Tìm slider theo ID
        $slider = Slider::find($id);
        if (!$slider) {
            return response()->json(['message' => 'Slider not found'], 404);
        }

        // Xác thực dữ liệu yêu cầu
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url_cv' => 'nullable|file|mimes:pdf|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Xử lý hình ảnh
        if ($request->hasFile('image')) {
            // Kiểm tra và xóa ảnh cũ nếu có
            if ($slider->image && Storage::disk('public')->exists($slider->image)) {
                Storage::disk('public')->delete($slider->image);
            }

            // Lấy tên gốc của tệp và thay thế khoảng trắng bằng dấu gạch dưới
            $imageName = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension(); // Sử dụng time() + uniqid() để đảm bảo tên duy nhất
            $imagePath = $request->file('image')->storeAs('images', $imageName, 'public');
            $validatedData['image'] = $imagePath;
        }

        // Xử lý CV PDF
        if ($request->hasFile('url_cv')) {
            $pdfName = $request->file('url_cv')->getClientOriginalName();
            $pdfPath = $request->file('url_cv')->storeAs('pdfs', $pdfName, 'public');
            $validatedData['url_cv'] = $pdfPath;
        }

        // Cập nhật slider với dữ liệu hợp lệ
        $slider->update($validatedData);
        return new SliderResource($slider);
    }



    public function destroy($id)
    {
        $slider = Slider::find($id);
        if ($slider) {
            $slider->delete();
            return response()->json(['message' => 'Slider deleted successfully']);
        } else {
            return response()->json(['message' => 'Slider not found'], 404);
        }
    }

    // Download CV
    public function downloadCV($id)
    {
        $slider = Slider::find($id); // Tìm slider theo ID
        if ($slider && $slider->url_cv) { // Kiểm tra xem slider và CV có tồn tại không
            $filePath = storage_path('app/public/' . $slider->url_cv); // Lấy đường dẫn tới tệp CV

            // Kiểm tra xem tệp có tồn tại không trước khi tải xuống
            if (file_exists($filePath)) {
                return response()->download($filePath, $slider->name . '.pdf'); // Tải xuống tệp với tên
            } else {
                return response()->json(['message' => 'CV file not found'], 404); // Tệp không tồn tại
            }
        } else {
            return response()->json(['message' => 'Slider not found or CV not available'], 404); // Không tìm thấy slider hoặc CV không khả dụng
        }
    }
}
