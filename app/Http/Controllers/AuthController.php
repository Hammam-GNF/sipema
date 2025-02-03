<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            $user = Auth::user();

            return $this->redirectUserBasedOnRole($user->role);
        }
        
        return view('auth.login');
    }

    public function actionLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()->toArray()
            ], 422);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            return $this->redirectUserBasedOnRole($user->role);
        } else {
            return back()->withErrors(['gagal' => 'Username atau password tidak valid.']);

            // return response()->json([
            //     'status' => 200,
            //     'message' => 'Login successful',
            //     'redirect_url' => route($user . '.dashboard')
            // ], 200);
        }

        // return response()->json([
        //     'status' => 401,
        //     'message' => 'Invalid credentials'
        // ], 401);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    private function redirectUserBasedOnRole($role)
    {
        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'user':
                return redirect()->route('user.dashboard');
            case 'petugas':
                return redirect()->route('petugas.dashboard');
            default:
                return redirect('/');
        }
    }
}
