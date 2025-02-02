<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PengaduanController extends Controller
{
    public function count()
    {
        $totalPengaduan = Pengaduan::count();
        return response()->json([
            'status' => 200,
            'totalPengaduan' => $totalPengaduan
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_petugas' => 'required|exists:petugas,id_petugas',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'date' => 'required|date',
            'deskripsi' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $pengaduan = Pengaduan::create([
            'id_petugas' => $request->id_petugas,
            'id_kategori' => $request->id_kategori,
            'deskripsi' => $request->description,
            'status' => 'terbuka', // set default status
            'date' => $request->date,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Pengaduan created successfully'
        ]);
    }


    public function getall()
    {
        $pengaduan = Pengaduan::with(['petugas', 'kategori'])
        ->where('status', 'terbuka')
        ->get();
        
        return response()->json([
            'status' => 200,
            'pengaduan' => $pengaduan
        ]);
    }


    public function edit($id)
    {
        $pengaduan = Pengaduan::find($id);
        if ($pengaduan) {
            return response()->json([
                'status' => 200,
                'pengaduan' => $pengaduan
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Pengaduan not found'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_petugas' => 'required|exists:petugas,id_petugas',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'date' => 'required|date',
            'description' => 'required|string|max:255',
            'treatment' => 'nullable|string|max:500',
            'veterinarian' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $pengaduan = Pengaduan::find($id);
        if (!$pengaduan) {
            return response()->json([
                'status' => 404,
                'message' => 'Pengaduan not found'
            ], 404);
        }

        $pengaduan->update($request->only(['id_petugas', 'id_kategori', 'date', 'description', 'treatment', 'veterinarian']));
        return response()->json([
            'status' => 200,
            'message' => 'Pengaduan updated successfully'
        ]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_pengaduan' => 'required|exists:pengaduan,id_pengaduan',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $pengaduan = Pengaduan::find($request->id);
        if ($pengaduan && $pengaduan->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'Pengaduan deleted successfully.'
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Failed to delete pengaduan.'
            ]);
        }
    }
}
