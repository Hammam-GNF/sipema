@extends('auth.template')

@section('page-scripts')
@include('auth.partials.scripts')
@endsection

@section('content')
<div class="limiter">
    <div class="container-login100" style="background-image: url('../loginAssets/images/bg-01.jpg');">
        <div class="wrap-login100 p-l-110 p-r-110 p-t-62 p-b-33">
            <form class="login100-form validate-form flex-sb flex-w" method="POST" id="loginForm">
                @csrf

                <span class=" login100-form-title p-b-53">
                    <h2 class="title-sipema">SIPEMA</h2>
                    <h4 class="title-signin">Sign In</h4>
                </span>

                <div class="p-t-31 p-b-9">
                    <span class="txt1">
                        Email
                    </span>
                </div>
                <div class="wrap-input100 validate-input" data-validate="Email is required">
                    <input class="input100" type="email" id="email" name="email" placeholder="Enter your email" required>
                    <span class="focus-input100"></span>
                    <span class="error-message text-danger" id="email-error"></span>
                </div>

                <div class="p-t-13 p-b-9">
                    <span class="txt1">
                        Password
                    </span>

                    <a href="#" class="txt2 bo1 m-l-5">
                        Forgot?
                    </a>
                </div>
                <div class="wrap-input100 validate-input" data-validate="Password is required">
                    <input class="input100" type="password" id="password" name="password" placeholder="Enter your password" required>
                    <span class="focus-input100"></span>
                    <span class="error-message text-danger" id="password-error"></span>
                </div>

                <div class="container-login100-form-btn m-t-17">
                    <button class="login100-form-btn" type="submit">
                        Sign In
                    </button>
                </div>

                <div class="w-full text-center p-t-55">
                    <span class="txt2">
                        Not a member?
                    </span>

                    <a href="{{ route('register') }}" class="txt2 bo1">
                        Sign up now
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>


<div id="dropDownSelect1"></div>
@endsection