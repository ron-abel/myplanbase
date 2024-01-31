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
                    <a href="" class="text-dark text-hover-black opacity-75 hover-opacity-100">Email Us Your Options</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section("content")
<div class="container">
    <h1>Email Us Your Options</h1>
    <div class="row">
        <div class="col-sm-8">
            <div class="card card-custom card-stretch">
                <div class="card-body">
                    <form action="{{ route('contractor.email.store', ['subdomain' => $subdomain]) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name :</label>
                            <input type="text" id="name" name="name" class="form-control form-control-solid @error('name') is-invalid @enderror" placeholder="Enter your name here" value="{{ old('name') }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email :</label>
                            <input type="text" id="email" name="email" class="form-control form-control-solid @error('email') is-invalid @enderror" placeholder="Enter your email address here" value="{{ old('email') }}">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone :</label>
                            <input type="text" id="phone" name="phone" class="form-control form-control-solid @error('phone') is-invalid @enderror w-50" placeholder="Enter your phone number here" value="{{ old('phone') }}">
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="home_location">Home Location :</label>
                                    <input type="text" id="home_location" name="home_location" class="form-control form-control-solid @error('home_location') is-invalid @enderror" placeholder="Enter your home location" value="{{ old('home_location') }}">
                                    @error('home_location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="state">State :</label>
                                    <select name="home_state" id="state" class="form-control form-control-solid custom-select @error('home_state') is-invalid @enderror">
                                        <option value="" {{ old("home_state") == "" ? "selected" : "" }}>Enter your state</option>
                                        @foreach ($states as $state)
                                        <option value="{{ $state }}" {{ old("home_state") == $state ? "selected" : "" }}>{{ $state }}</option>
                                        @endforeach
                                    </select>
                                    @error('home_state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="zip">Zip Code :</label>
                                    <input type="text" id="zip" name="home_zip" class="form-control form-control-solid @error('home_zip') is-invalid @enderror" placeholder="Enter your zip" value="{{ old('home_zip') }}">
                                    @error('home_zip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="comments">Comments</label>
                            <textarea name="note" id="comments" class="form-control form-control-solid @error('note') is-invalid @enderror" rows="10">{{ old('note') }}</textarea>
                            @error('note')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <input type="hidden" name="floorplan_id" value="{{ $floorplan->id }}">
                        <button type="submit" class="btn btn-primary float-right">Email Us Your Options</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4 pl-10">
            <div class="item-image">
                <img src="{{ $floorplan->images[0]['pic_url'] }}" alt="{{ $floorplan->images[0]['pic_name'] }}">
            </div>
            <p class="mt-2 mb-5 h2">{{ $floorplan->plan_description }}</p>
            <p>{{ $floorplan->plan_additional_text }}</p>
            <hr>
            @include('contractor.includes.items', ['contractor' => $contractor, 'floorplan' => $floorplan, 'subdomain' => $subdomain])
            <div class="d-flex">
                <a href="{{ route('contractor.pdf.create', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id]) }}" class="btn btn-primary mr-10">Download PDF</a>
                <a href="{{ route('contractor.email.create', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id]) }}" class="btn btn-primary flex-grow-1">Email Us Your Option</a>
            </div>
        </div>
    </div>
</div>

@include("contractor.includes.item-single")
@endsection