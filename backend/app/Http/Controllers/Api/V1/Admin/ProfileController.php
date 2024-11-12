<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ProfileResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        // Nếu không cần xác thực, có thể lấy tất cả người dùng hoặc một người dùng cụ thể
        $users = Auth::user(); // Hoặc tìm một người dùng cụ thể
        return new ProfileResource($users);
    }

    public function update(Request $request, $id)
    {
        // Retrieve user by ID
        $user = User::find($id);

        // Check if user exists
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404); // Thêm kiểm tra nếu không tìm thấy người dùng
        }

        // Validate request data
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'], // Make password nullable
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        // Update user's attributes
        $user->fill($validatedData);

        // Only update the password if it's provided
        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']); // Bảo mật mật khẩu
        }

        $user->save(); // Save changes to the database

        return new ProfileResource($user);
    }

    // public function destroy($id)
    // {
    //     $user = User::find($id); // Dùng find để tìm người dùng

    //     // Check if user exists
    //     if (!$user) {
    //         return response()->json(['message' => 'User not found.'], 404);
    //     }

    //     $user->delete(); // Xóa người dùng
    //     return response()->json(['message' => 'User deleted successfully.'], 204); // 204 No Content
    // }
}
