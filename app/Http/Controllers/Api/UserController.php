<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserModel;

class UserController extends Controller
{
    public function index()
    {
        return response()->json([
            'status_code' => 200,
            'data' => UserModel::with('level')->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'level_id' => 'required',
            'username' => 'required|unique:m_user',
            'nama' => 'required',
            'password' => 'required'
        ]);

        $user = UserModel::create([
            'level_id' => $request->level_id,
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return response()->json([
            'status_code' => 201,
            'data' => $user
        ]);
    }

    public function show(UserModel $user)
    {
        $user->load('level');

        return response()->json([
            'status_code' => 200,
            'user' => $user,
            'level' => $user->level
        ]);
    }

    public function update(Request $request, UserModel $user)
    {
        $user->update([
            'level_id' => $request->filled('level_id') ? $request->level_id : $user->level_id,
            'username' => $request->filled('username') ? $request->username : $user->username,
            'nama' => $request->filled('nama') ? $request->nama : $user->nama,
            'password' => $request->filled('password') ? bcrypt($request->password) : $user->password,
            'updated_at' => now(),
        ]);

        return response()->json([
            'status_code' => 200,
            'data' => $user,
        ]);
    }

    public function destroy(UserModel $user)
    {
        $user->delete();

        return response()->json([
            'status_code' => 204,
            'success' => true,
            'message' => 'Data terhapus',
        ]);
    }
}
