<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\Pengaduan;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PetugasController extends Controller
{
    public function dashboard()
    {
        if (!Auth::check() || Auth::user()->role !== 'petugas') {
            return redirect()->route('login')->with('error', 'Anda tidak berhak mengakses halaman ini.');
        }

        $user = Auth::user();

        return view('petugas.dashboard', compact('user'));
    }

    // PENGADUAN
    public function countPengaduan()
    {
        $user = Auth::user();
        $petugas = Petugas::where('id_user', $user->id_user)->first();

        $totalPengaduan = Pengaduan::where('id_petugas', $petugas->id_petugas)->count();
        return response()->json([
            'status' => 200,
            'totalPengaduan' => $totalPengaduan
        ]);
    }

    public function getallPengaduan(Request $request)
    {
        $user = Auth::user();
        $petugas = Petugas::where('id_user', $user->id_user)->first();

        $pengaduan = Pengaduan::with([
            'petugas.user:id_user,name',
            'user:id_user,name,email'
        ])->where('id_petugas', $petugas->id_petugas)->get();

        return response()->json([
            'status' => 200,
            'pengaduan' => $pengaduan
        ]);
    }

    public function editPengaduan($id_pengaduan)
    {
        $pengaduan = Pengaduan::find($id_pengaduan);
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

    public function updatePengaduan(Request $request, $id_pengaduan)
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

        $pengaduan = Pengaduan::find($id_pengaduan);
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
    // END PENGADUAN

    // NOTIFIKASI
    public function getallNotifikasi()
    {
        $notifikasi = Notifikasi::with([
            'user:id_user,name,email',
            'pengaduan:id_pengaduan,judul_pengaduan'
        ])->get();

        return response()->json([
            'status' => 200,
            'notifikasi' => $notifikasi
        ]);
    }
    // END NOTIFIKASI
}
