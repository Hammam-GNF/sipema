<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Pengaduan;
use App\Models\Petugas;
use App\Models\TindakLanjut;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Anda tidak berhak mengakses halaman ini.');
        }

        $user = Auth::user();

        return view('admin.dashboard', compact('user'));
    }

    // PETUGAS
    public function countPetugas()
    {
        $totalPetugas = Petugas::count();
        return response()->json([
            'status' => 200,
            'totalPetugas' => $totalPetugas
        ]);
    }

    public function storePetugas(Request $request)
    {
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

    public function getallPetugas()
    {
        $petugas = Petugas::with('user')->get();
        return response()->json([
            'status' => 200,
            'petugas' => $petugas
        ]);
    }

    public function editPetugas($id_petugas)
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

    public function updatePetugas(Request $request)
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

    public function deletePetugas(Request $request)
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
    // END PETUGAS

    // USER
    public function countUser()
    {
        $totalUser = User::where('role', 'User')->count();
        return response()->json([
            'status' => 200,
            'totalUser' => $totalUser
        ]);
    }
    public function storeUser(Request $request)
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

    public function getallUser()
    {
        $users = User::where('role', 'User')->get();
        return response()->json([
            'status' => 200,
            'user' => $users
        ]);
    }

    public function editUser($id_user)
    {
        $user = User::find($id_user);
        if ($user) {
            return response()->json([
                'status' => 200,
                'user' => $user
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'User tidak ditemukan'
            ]);
        }
    }

    public function updateUser(Request $request)
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
            $user->update($request->only(['name', 'email', 'role']));

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

    public function deleteUser(Request $request)
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
    // END USER

    // PENGADUAN
    public function countPengaduan()
    {
        $totalPengaduan = Pengaduan::count();
        return response()->json([
            'status' => 200,
            'totalPengaduan' => $totalPengaduan
        ]);
    }

    public function getallPengaduan()
    {
        $pengaduan = Pengaduan::with([
            'user:id_user,name,email',
            'petugas.user:id_user,name'
        ])->get();
        return response()->json([
            'status' => 200,
            'pengaduan' => $pengaduan
        ]);
    }
    public function countTindakLanjut()
    {
        $totalTindakLanjut = TindakLanjut::count();
        return response()->json([
            'status' => 200,
            'totalTindakLanjut' => $totalTindakLanjut
        ]);
    }

    public function getallTindakLanjut()
    {
        $tindakLanjut = TindakLanjut::with([
            'petugas.user:id_user,name',
            'pengaduan:id_pengaduan,judul_pengaduan'
        ])->get();
        return response()->json([
            'status' => 200,
            'tindakLanjut' => $tindakLanjut
        ]);
    }
    // END PENGADUAN

    // LAPORAN
    public function countLaporan()
    {
        $totalLaporan = Laporan::count();
        return response()->json([
            'status' => 200,
            'totalLaporan' => $totalLaporan
        ]);
    }

    public function getallLaporan()
    {
        $laporan = Laporan::with([
            'petugas.user:id_user,name',
            'pengaduan:id_pengaduan,judul_pengaduan'
        ])->get();
        return response()->json([
            'status' => 200,
            'laporan' => $laporan
        ]);
    }
    // END LAPORAN

}
