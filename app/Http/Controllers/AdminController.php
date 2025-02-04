<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Anda tidak berhak mengakses halaman ini.');
        }

        return view('admin.dashboard');
    }

}
