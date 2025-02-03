<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PetugasController extends Controller
{
    public function count()
    {
        $totalPetugas = Petugas::count();
        return response()->json([
            'status' => 200,
            'totalPetugas' => $totalPetugas
        ]);
    }

    public function store(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:petugas,email|max:255',
            'role' => 'required|in:admin,petugas',
            'password' => 'required|string|min:6|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $petugasData = $request->only(['name', 'email', 'role']);
        $petugasData['password'] = Hash::make($request->password);

        Petugas::create($petugasData);

        return response()->json([
            'status' => 200,
            'message' => 'Petugas berhasil ditambahkan.'
        ]);
    }

    public function getall()
    {
        $petugas = Petugas::with('user')->get();
        return response()->json([
            'status' => 200,
            'petugas' => $petugas
        ]);
    }

    public function edit($id_petugas)
    {
        $petugas = Petugas::find($id_petugas);

        if ($petugas) {
            return response()->json([
                'status' => 200,
                'petugas' => $petugas
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Petugas tidak ditemukan'
            ]);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_petugas' => 'required|exists:petugas,id_petugas',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:petugas,email,' . $request->id_petugas . ',id_petugas|max:255',
            'role' => 'required|in:admin,petugas',
            'password' => 'nullable|string|min:6|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $petugas = Petugas::find($request->id_petugas);

        if ($petugas) {
            $petugas->update($request->only(['name', 'email', 'role']));

            if ($request->has('password') && $request->password != '') {
                $petugas->password = $request->password;
                $petugas->save();
            }

            return response()->json([
                'status' => 200,
                'message' => 'Petugas berhasil diperbarui.'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Petugas tidak ditemukan'
            ]);
        }
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_petugas' => 'required|exists:petugas,id_petugas',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $petugas = Petugas::find($request->id_petugas);
        if ($petugas && $petugas->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'Petugas berhasil dihapus.'
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Gagal menghapus petugas.'
            ]);
        }
    }
}
