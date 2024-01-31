@extends('admin.layouts.logindefault')

@section('title', 'Myplanbase - Super Admin Login Credentials Required')

@section('content')
<div class="main-container">
    <div class="container-login">
        <div class="wrap-login">
            <div class="logo">
                <a href="{{route('super.welcome')}}">
                    <img src="{{ asset('img/client/cropped-zipkit-logo.png') }}" style="width:100%;max-height:100px;" alt="Myplanbase Logo">
                </a>
            </div>
            <div class="login100-form-title-1 py-3">
                Contractor Registration
            </div>
            <div class="py-3 px-5">
                <form method="post" action="{{ route('super.contractors.store') }}">
                    @csrf
                    @if ( session()->has('error') )
                    <div style="width:100%; padding:5px; font-size:13px; font-weight:bold; color:#f00; text-align:center;">
                        {{ session()->get('error') }}
                    </div>
                    @endif
                    @if(session()->has('success'))
                    <div class="text-success" style="width:100%; padding:5px; font-size:13px; font-weight:bold;  text-align-center">
                        {{ session()->get('success') }}
                    </div>
                    @endif
                    @if(session()->has('info'))
                    <div class="text-info" style="width:100%; padding:5px; font-size:13px; font-weight:bold; text-align-center">
                        {{ session()->get('info') }}
                    </div>
                    @endif



                    <div class="row align-items-start">
                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="company_name">Company name :</label>
                            <input id="company_name" name="company_name" class="form-control form-control-solid @error('company_name') is-invalid @enderror" placeholder="Enter plan name" value="{{ old('company_name') }}">
                            @error('company_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row align-items-start">
                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="sub_domain">Sub domain :</label>
                            <input id="sub_domain" name="sub_domain" class="form-control form-control-solid @error('sub_domain') is-invalid @enderror" placeholder="Enter sub domain" value="{{ old('sub_domain') }}">
                            @error('sub_domain')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row align-items-start">
                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="company_website">Company website :</label>
                            <input id="company_website" name="company_website" class="form-control form-control-solid @error('company_website') is-invalid @enderror" placeholder="Enter company website" value="{{ old('company_website') }}">
                            @error('company_website')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row align-items-start">
                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="address">Address :</label>
                            <input id="address" name="address" class="form-control form-control-solid @error('address') is-invalid @enderror" placeholder="Enter address" value="{{ old('address') }}">
                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row align-items-start">
                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="state">State :</label>
                            <select name="state" class="form-control form-control-solid custom-select @error('address') is-invalid @enderror">
                                <option value="" {{ old("state") == "" ? "checked" : "" }}></option>
                                @foreach ($states as $state)
                                <option value="{{ $state }}" {{ old("state") == $state ? "checked" : "" }}>{{ $state }}</option>
                                @endforeach
                            </select>
                            @error('state')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row align-items-start">
                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="country">Country :</label>
                            <input id="country" name="country" class="form-control form-control-solid @error('country') is-invalid @enderror" placeholder="Enter country" value="{{ old('country') }}">
                            @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row align-items-start">
                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="zip">Zip :</label>
                            <input id="zip" name="zip" class="form-control form-control-solid @error('zip') is-invalid @enderror" placeholder="Enter zip" value="{{ old('zip') }}">
                            @error('zip')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row align-items-start">
                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="logo">Logo :</label>
                            <div class="custom-file">
                                <input type="hidden" name="logo" value="{{ old('logo') }}">
                                <input type="file" class="custom-file-input @error('logo') is-invalid @enderror" id="logo">
                                <label class="custom-file-label" for="logo">{{ old('logo') == "" ? "Drag Picture Here" : "File attached" }}</label>
                                @error("logo")
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @if (old('logo') != "")
                            <img src="{{ old('logo') }}" width="100" height="100" class="img-thumbnail">
                            @endif
                        </div>
                    </div>

                    <div class="row align-items-start">
                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="business_description">Business description :</label>
                            <textarea id="business_description" name="business_description" class="form-control form-control-solid @error('business_description') is-invalid @enderror" placeholder="Enter business description" rows="10">{{ old('business_description') }}</textarea>
                            @error('business_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row align-items-start">
                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="first_name">Fist Name :</label>
                            <input id="first_name" name="first_name" class="form-control form-control-solid @error('first_name') is-invalid @enderror" placeholder="Enter first name" value="{{ old('first_name') }}">
                            @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row align-items-start">
                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="last_name">Last Name :</label>
                            <input id="last_name" name="last_name" class="form-control form-control-solid @error('last_name') is-invalid @enderror" placeholder="Enter last name" value="{{ old('last_name') }}">
                            @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row align-items-start">
                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="email">Email :</label>
                            <input id="email" name="email" class="form-control form-control-solid @error('email') is-invalid @enderror" placeholder="Enter email" value="{{ old('email') }}">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row align-items-start">
                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="password">Password :</label>
                            <input type="password" id="password" name="password" class="form-control form-control-solid @error('password') is-invalid @enderror" placeholder="Enter password">
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-block">Register Contractor</button>
                </form>
            </div>

        </div>
    </div>
    @extends('admin.layouts.footerfront')
</div>
@stop

@section("css")
<style>
    .wrap-login {
        padding: 35px 0px 55px 0px;
    }

    .logo {
        display: flex;
        justify-content: center;
    }

    .login100-form-title-1 {
        background-color: #d9d9d9;
    }

    button {
        margin-top: 20px !important;
        background-color: #ff822a !important;
        color: white !important;
    }
</style>
@endsection

@section("scripts")
<script src="{{ asset('../js/custom.js') }}"></script>
@endsection