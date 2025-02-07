@extends('auth.template')

@section('page-scripts')
@include('auth.partials.scripts')
@endsection

@section('content')
<div class="limiter">
    <div class="container-login100" style="background-image: url('../loginAssets/images/bg-01.jpg');">
        <div class="wrap-login100 p-l-110 p-r-110 p-t-62 p-b-33">
            <form class="login100-form validate-form flex-sb flex-w" method="POST" id="registerForm">
                @csrf

                <span class=" login100-form-title p-b-53">
                    <h2 class="title-sipema">SIPEMA</h2>
                    <h4 class="title-signin">Sign Up</h4>
                </span>

                <div class="p-t-31 p-b-9">
                    <span class="txt1">Name</span>
                </div>
                <div class="wrap-input100">
                    <input class="input100" type="text" id="name" name="name" placeholder="Enter your name" required>
                </div>

                <div class="p-t-31 p-b-9">
                    <span class="txt1">Email</span>
                </div>
                <div class="wrap-input100">
                    <input class="input100" type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="p-t-31 p-b-9">
                    <span class="txt1">Role</span>
                </div>
                <div class="wrap-input100">
                    <select class="input100" id="role" name="role" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                        <option value="petugas">Petugas</option>
                    </select>
                </div>

                <div class="p-t-13 p-b-9">
                    <span class="txt1">Password</span>
                </div>
                <div class="wrap-input100">
                    <input class="input100" type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>

                <div class="p-t-13 p-b-9">
                    <span class="txt1">Confirm Password</span>
                </div>
                <div class="wrap-input100">
                    <input class="input100" type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required>
                </div>

                <div class="container-login100-form-btn m-t-17">
                    <button class="login100-form-btn" type="submit">
                        Sign Up
                    </button>
                </div>

                <div class="w-full text-center p-t-55">
                    <span class="txt2">Already a member?</span>
                    <a href="{{ route('login') }}" class="txt2 bo1">Sign in now</a>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="dropDownSelect1"></div>
@endsection