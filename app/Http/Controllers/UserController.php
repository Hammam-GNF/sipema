<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\Pengaduan;
use App\Models\Petugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function dashboard()
    {
        if (!Auth::check() || Auth::user()->role !== 'user') {
            return redirect()->route('login')->with('error', 'Anda tidak berhak mengakses halaman ini.');
        }

        $user = Auth::user();

        return view('user.dashboard', compact('user'));
    }
    public function countPengaduan()
    {
        $userId = Auth::id();

        $totalPengaduan = Pengaduan::where('id_user', $userId)->count();
        return response()->json([
            'status' => 200,
            'totalPengaduan' => $totalPengaduan
        ]);
    }
    public function countNotifikasi()
    {
        $userId = Auth::id();

        $totalNotifikasi = Notifikasi::where('id_user', $userId)->count();
        return response()->json([
            'status' => 200,
            'totalNotifikasi' => $totalNotifikasi
        ]);
    }

    public function storePengaduan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul_pengaduan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'tanggal_pengaduan' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $randomPetugas = Petugas::inRandomOrder()->first();

        $validatedData = $request->all();
        $validatedData['status'] = 'Menunggu Verifikasi';
        $validatedData['id_user'] = Auth::id();
        $validatedData['id_petugas'] = $randomPetugas ? $randomPetugas->id_petugas : null;

        if ($request->hasFile('bukti')) {
            $validatedData['bukti'] = $request->file('bukti')->store('bukti_pengaduan');
        }

        $pengaduan = Pengaduan::create($validatedData);

        return response()->json([
            'status' => 200,
            'message' => 'Pengaduan berhasil ditambahkan.'
        ]);
    }

    public function getallPengaduan()
    {
        $id_user = $request->id_user ?? Auth::id();

        $pengaduan = Pengaduan::with([
            'user:id_user,name,email',
            'petugas.user:id_user,name'
        ])->where('id_user', $id_user)->get();

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

    public function updateStatus($id_notifikasi)
    {
        Notifikasi::where('id_notifikasi', $id_notifikasi)->where('status_baca', 0)->update(['status_baca' => 1]);

        return response()->json([
            'status' => 200,
            'message' => 'Status diperbarui menjadi terbaca'
        ]);
    }

    public function deletePengaduan(Request $request)
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
    // END PENGADUAN

    // NOTIFIKASI
    public function getallNotifikasi()
    {
        $id_user = $request->id_user ?? Auth::id();

        $notifikasi = Notifikasi::with([
            'user:id_user,name,email',
            'pengaduan:id_pengaduan,judul_pengaduan'
        ])->where('id_user', $id_user)->get();

        return response()->json([
            'status' => 200,
            'notifikasi' => $notifikasi
        ]);
    }

    // END NOTIFIKASI
}
