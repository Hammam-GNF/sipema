<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register()
    {
        return view('auth.register');
    }

    public function actionRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,user,petugas',
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()->toArray()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'email_verified_at' => now()
        ]);

        $user->notify(new EmailVerification());

        return response()->json([
            'status' => 200,
            'message' => 'Registration successful. Please check your email.',
            'redirect_url' => route('register')
        ], 201);
    }

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

        if (Auth::attempt($credentials, true)) {
            $request->session()->regenerate();
            $user = Auth::user();

            $validRoles = ['admin', 'user', 'petugas'];
            $role = $user->role;

            if (in_array($role, $validRoles)) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Login successful',
                    'redirect_url' => route($role . '.dashboard')
                ], 200);
            }
        }

        return response()->json([
            'status' => 401,
            'message' => 'Invalid credentials'
        ], 401);
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Auth::logout();

        return response()->json([
            'status' => 200,
            'message' => 'Logout berhasil!',
            'redirect_url' => route('login')
        ]);
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
