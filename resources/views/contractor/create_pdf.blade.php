@extends("contractor.layouts.default")

@php
$floorplan_name = $floorplan->pivot->is_keep_same_name == 1 ? $floorplan->plan_name : $floorplan->pivot->floor_plan_rename;
@endphp

@section("subheader")
<div class="subheader py-2 py-lg-12 subheader-transparent" id="kt_subheader">
    <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex flex-column">
                <div class="d-flex align-items-center font-weight-bold my-2">
                    <span class="label label-dot label-sm bg-dark opacity-75 mx-3"></span>
                    <a href="{{ route('contractor.floorplans.index', ['subdomain' => $subdomain]) }}" class="text-dark text-hover-black opacity-75 hover-opacity-100">Floor Plans</a>
                    <span class="label label-dot label-sm bg-dark opacity-75 mx-3"></span>
                    <a href="{{ route('contractor.floorplans.show', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id]) }}" class="text-dark text-hover-black opacity-75 hover-opacity-100">{{ $floorplan_name }}</a>
                    <span class="label label-dot label-sm bg-dark opacity-75 mx-3"></span>
                    <a href="{{ route('contractor.productgroups.index', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id]) }}" class="text-dark text-hover-black opacity-75 hover-opacity-100">Options & Colors</a>
                    <span class="label label-dot label-sm bg-dark opacity-75 mx-3"></span>
                    <a href="" class="text-dark text-hover-black opacity-75 hover-opacity-100">Download PDF</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section("content")
<div class="container">
    <h1>Download PDF of Your Options</h1>
    <div class="row">
        <div class="col"></div>
        <div class="col-sm-8">
            <div class="card card-custom card-stretch">
                <div class="card-body">
                    <form action="{{ route('contractor.pdf.store', ['subdomain' => $subdomain]) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="item-image">
                                    <img src="{{ $floorplan->images[0]['pic_url'] }}" alt="{{ $floorplan->images[0]['pic_name'] }}">
                                </div>
                                <p class="text-center">{{ $floorplan_name }}</p>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control form-control-solid @error('name') is-invalid @enderror" placeholder="Enter your name" value="{{ old('name') }}">
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="text" name="email" class="form-control form-control-solid @error('email') is-invalid @enderror" placeholder="Enter your email address" value="{{ old('email') }}">
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="text" name="phone" class="form-control form-control-solid @error('phone') is-invalid @enderror" placeholder="Enter your phone number" value="{{ old('phone') }}">
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="text" name="home_location" class="form-control form-control-solid @error('home_location') is-invalid @enderror" placeholder="Enter your home_location number" value="{{ old('home_location') }}">
                                    @error('home_location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="form-group">
                                        <select name="home_state" class="form-control form-control-solid custom-select @error('home_state') is-invalid @enderror">
                                            <option value="" {{ old("home_state") == "" ? "selected" : "" }}>Enter your state</option>
                                            @foreach ($states as $state)
                                            <option value="{{ $state }}" {{ old("home_state") == $state ? "selected" : "" }}>{{ $state }}</option>
                                            @endforeach
                                        </select>
                                        @error('home_state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="home_zip" class="form-control form-control-solid @error('home_zip') is-invalid @enderror" placeholder="Enter your zip" value="{{ old('home_zip') }}">
                                        @error('home_zip')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        @include("contractor.includes.items", ["contractor" => $contractor, "floorplan" => $floorplan, "not_editable" => true, "subdomain" => $subdomain])
                        <input type="hidden" name="floor_plan_id" value="{{ $floorplan->id }}">
                        <button type="submit" class="btn btn-primary float-right">Download PDF</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col"></div>
    </div>
</div>
@endsection