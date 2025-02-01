<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use Illuminate\Http\Request;
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
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $petugasData = $request->only(['name', 'address', 'phone']);
        Petugas::create($petugasData);

        return response()->json([
            'status' => 200,
            'message' => 'Petugas created successfully'
        ]);
    }

    public function getall()
    {
        $petugas = Petugas::all();
        return response()->json([
            'status' => 200,
            'petugas' => $petugas
        ]);
    }

    public function edit($id)
    {
        $petugas = Petugas::find($id);

        if ($petugas) {
            return response()->json([
                'status' => 200,
                'petugas' => $petugas
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Petugas not found'
            ]);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_petugas' => 'required|exists:petugas,id_petugas',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $petugas = Petugas::find($request->id);

        if ($petugas) {
            $petugas->update($request->only(['name', 'address', 'phone']));
            return response()->json([
                'status' => 200,
                'message' => 'Petugas updated successfully'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Petugas not found'
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

        $petugas = Petugas::find($request->id);

        if ($petugas && $petugas->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'Petugas deleted successfully.'
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Failed to delete petugas.'
            ]);
        }
    }
}
