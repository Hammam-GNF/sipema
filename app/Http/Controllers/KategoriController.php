<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    public function count()
    {
        $totalKategori = Kategori::count();
        return response()->json([
            'status' => 200,
            'totalKategori' => $totalKategori
        ]);
    }
    public function store(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $kategoriData = $request->only(['nama_kategori']);
        Kategori::create($kategoriData);

        return response()->json([
            'status' => 200,
            'message' => 'Kategori berhasil ditambahkan.'
        ]);
    }

    public function getall()
    {
        $kategori = Kategori::all();
        return response()->json([
            'status' => 200,
            'kategori' => $kategori
        ]);
    }

    public function edit($id_kategori)
    {
        $kategori = Kategori::find($id_kategori);
        if ($kategori) {
            return response()->json([
                'status' => 200,
                'kategori' => $kategori
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Kategori tidak ditemukan'
            ]);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $kategori = Kategori::find($request->id_kategori);
        if ($kategori) {
            $kategori->update($request->only(['nama_kategori']));
            return response()->json([
                'status' => 200,
                'message' => 'Kategori berhasil diperbarui'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Kategori tidak ditemukan'
            ]);
        }
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_kategori' => 'required|exists:kategori,id_kategori',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $kategori = Kategori::find($request->id_kategori);
        if ($kategori && $kategori->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'Kategori berhasil dihapus.'
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Gagal menghapus kategori.'
            ]);
        }
    }
}
