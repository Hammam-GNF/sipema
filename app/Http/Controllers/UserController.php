<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function count()
    {
        $totalUser = User::where('role', 'User')->count();
        return response()->json([
            'status' => 200,
            'totalUser' => $totalUser
        ]);
    }
    public function store(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,user,petugas',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $userData = $request->only(['name', 'email', 'role', 'password']);
        $userData['password'] = bcrypt($userData['password']);

        User::create($userData);

        return response()->json([
            'status' => 200,
            'message' => 'User berhasil ditambahkan.'
        ]);
    }

    public function getall()
    {
        $users = User::where('role', 'User')->get();
        return response()->json([
            'status' => 200,
            'user' => $users
        ]);
    }

    public function edit($id_user)
    {
        $user = User::find($id_user);
        if ($user) {
            return response()->json([
                'status' => 200,'user' => $user
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'User tidak ditemukan'
            ]);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->id_user . ',id_user|max:255',
            'role' => 'required|in:admin,user,petugas',
            'password' => 'nullable|string|min:8', 
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::find($request->id_user);

        if ($user) {
            $user -> update($request->only(['name', 'email', 'role']));

            if ($request->has('password') && $request->password != '') {
                $user->password = $request->password;
                $user->save();
            }

            return response()->json([
                'status' => 200,
                'message' => 'User berhasil diperbarui.'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'User tidak ditemukan'
            ]);
        }
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required|exists:users,id_user',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::find($request->id_user);
        if ($user && $user->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'User berhasil dihapus.'
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Gagal menghapus user.'
            ]);
        }
    }
}
