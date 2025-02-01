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
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'age' => 'required|integer',
            'description' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $kategoriData = $request->only(['name', 'species', 'age', 'description']);
        Kategori::create($kategoriData);

        return response()->json([
            'status' => 200,
            'message' => 'Kategori created successfully'
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

    public function edit($id)
    {
        $kategori = Kategori::find($id);
        if ($kategori) {
            return response()->json([
                'status' => 200,
                'kategori' => $kategori
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Kategori not found'
            ]);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'age' => 'required|integer',
            'description' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $kategori = Kategori::find($request->id);
        if ($kategori) {
            $kategori->update($request->only(['name', 'species', 'age', 'description']));
            return response()->json([
                'status' => 200,
                'message' => 'Kategori updated successfully'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Kategori not found'
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

        $kategori = Kategori::find($request->id);
        if ($kategori && $kategori->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'Kategori deleted successfully.'
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Failed to delete kategori.'
            ]);
        }
    }
}
