@extends('admin.layouts.logindefault')

@section('title', 'Forgot password')

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
                    Reset Password
                </span>
            </div>
            <form method="post" action="{{ route('contractor.password.update', ['subdomain' => $subdomain]) }}" class="login100-form validate-form">
                @csrf
                @if (session()->has('error') )
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
                    <input class="input100" type="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required />
                </div>

                <div class="wrap-input100 validate-input m-b-20 mt-2" data-validate="User password is required">
                    <input class="input100" type="password" name="password" placeholder="Enter your password" required />
                </div>

                <div class="wrap-input100 validate-input m-b-20 mt-2" data-validate="User password confirmation is required">
                    <input class="input100" type="password" name="password_confirmation" placeholder="Enter your password confirmation" required />
                </div>

                <input type="hidden" name="token" value="{{ $token }}">

                <button type="submit" role="submit" class="login100-form-btn">Save</button>
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