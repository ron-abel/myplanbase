<?php
$contractor = App\Models\Contractor::where("sub_domain", $subdomain)->first();
$is_active = 1;
?>
@extends('admin.layouts.logindefault')

@section('title', 'Myplanbase Admin Login')

@section('content')
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <div style="padding-right:14%;padding-left:14%;">
                <a href="">
                    @isset($contractor->logo)
                    <img src="{{ $contractor->logo }}" style="width:100%; max-height:65px;" alt="Logo">
                    @else
                    <img src="{{ asset('img/client/cropped-zipkit-logo.png') }}" alt="Myplanbase Logo" class="login-logo">
                    @endisset
                </a>
            </div>
            <div class="login100-form-title">
                <span class="login100-form-title-1">
                    Contractor Admin Login
                </span>
            </div>
            <form method="post" action="{{ route('contractor.admin.login', ['subdomain' => $subdomain ,'token'=> request()->get('token', '')]) }}" class="login100-form validate-form">
                @csrf
                @if ( session()->has('error') )
                <div style="width:100%; padding:5px; font-size:13px; font-weight:bold; color:#f00; text-align:center;">
                    {{ session()->get('error') }}
                </div>
                @endif
                @if(session()->has('success'))

                <div class="text-success" style="width:100%; padding:5px; font-size:13px; font-weight:bold; text-align-center">
                    {{ session()->get('success') }}
                </div>
                @endif
                @if(session()->has('info'))
                <div class="text-info" style="width:100%; padding:5px; font-size:13px; font-weight:bold; text-align-center">
                    {{ session()->get('info') }}
                </div>
                @endif

                <div class="wrap-input100 validate-input m-b-20 mt-2" data-validate="User email is required">
                    <input class="input100" type="email" name="email" placeholder="Enter your email" required />
                </div>

                @error('email')
                <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}</p>
                @enderror

                <div class="wrap-input100 validate-input m-b-15" data-validate="Password is required">
                    <input name="password" class="input100" type="password" placeholder="Enter Your Password" required />


                </div>

                @error('email')
                <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}</p>
                @enderror

                <div class="form-check col-md-12  ml-1">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label style="font-size:14px;" class="" for="remember">
                        Remember Me
                    </label>
                </div>

                <div class="container-login100-form-btn">
                    @if($is_active && $contractor)
                    <!-- <input type="submit" class="login100-form-btn" value="Login" /> -->
                    <button type="submit" role="submit" class="login100-form-btn">Login</button>
                    @else
                    <button disabled="disabled" type="button" role="button" class="login-form-btn login100-form-btn">Login</button>
                    @endif
                </div>


                <div class="col-md-12 text-center">
                    <a href="{{ route('contractor.password.request', ['subdomain' => $subdomain]) }}">Forgot Password?</a>
                </div>
                @if(!$contractor)
                <div class="col-md-12 text-center">
                    <p class="text-danger mt-2">
                        The Contractor is invalid. Please ask to support team.
                    </p>
                </div>
                @else
                @if(!$is_active)
                <div class="col-md-12 text-center">
                    <p class="text-danger mt-2">
                        This portal is inactive. Please email admin@myplanbase.com for help.
                    </p>
                </div>
                @endif
                @endif
            </form>

        </div>
    </div>
    <footer class="lc-md">
        <div class="footer-r">Powered by
            <!-- <img src="{{ asset('img/client/myplanbase-emblem.png') }}" class="footer-logo"> -->
            <span class="ml-1"><a href="javascript:;" target="_blank">Myplanbase</a> - Myplanbase Contractor Portal</span>
            <span class="ml-4">© {{ __('Copyright') }} {{ date('Y') }} | {{ __('All Rights Reserved') }} | @version('footer-version')</span>
        </div>
    </footer>
</div>
@php
$success = session()->get('successMessage');
session()->forget('successMessage');
@endphp
@stop
@section('scripts')
<script>
    var success = "{{ $success }}";
    if (success != "") {
        Swal.fire({
            text: success,
            icon: "success",
        });
    }
</script>
@endsection