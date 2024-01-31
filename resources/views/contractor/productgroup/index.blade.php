@extends('contractor.layouts.default')

@php
if($errors->any()){
if(session()->has("color-list") && session()->get('color-list'))
echo "<script>
    window.showColorListModal = true;
</script>";
echo "<script>
    window.showColorModal = true;
</script>";
}

$floorplan_name = $floorplan->pivot->is_keep_same_name == 1 ? $floorplan->plan_name : $floorplan->pivot->floor_plan_rename;
@endphp

@section('subheader')
<div class="subheader py-2 py-lg-12 subheader-transparent" id="kt_subheader">
    <div class="container">
        <a href="{{ route('contractor.floorplans.show', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id]) }}" class="btn text-white btn-sm mb-5" style="background-color: grey;">
            <i class="las la-arrow-left text-white"></i>
            <span>Back</span>
        </a>
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex flex-column">
                <div class="d-flex align-items-center font-weight-bold my-2">
                    <span class="label label-dot label-sm bg-dark opacity-75 mx-3"></span>
                    <a href="{{ route('contractor.floorplans.index', ['subdomain' => $subdomain]) }}" class="text-dark text-hover-black opacity-75 hover-opacity-100">Floor Plans</a>
                    <span class="label label-dot label-sm bg-dark opacity-75 mx-3"></span>
                    <a href="{{ route('contractor.floorplans.show', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id]) }}" class="text-dark text-hover-black opacity-75 hover-opacity-100">{{ $floorplan_name }}</a>
                    <span class="label label-dot label-sm bg-dark opacity-75 mx-3"></span>
                    <a href="" class="text-dark text-hover-black opacity-75 hover-opacity-100">Options & Colors</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container">
    <h1>Options & Colors</h1>
    <div class="row">
        <div class="col-md-6 border-right">
            <div class="row">
                @foreach ($productgroups as $productgroup)
                <div class="col-md-6 p-5">
                    <a class="card card-custom card-stretch" href="{{ route('contractor.productgroups.show', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id, 'productgroup' => $productgroup]) }}">
                        <div class="card-body p-0 item-small-image">
                            <img src="{{ $productgroup->images[0]['pic_url'] }}" alt="{{ $productgroup->images[0]['pic_name'] }}">
                        </div>
                        <div class="card-header border-0 p-5">
                            <div class="card-title">
                                <div class="card-label">
                                    <div class="mt-2 text-danger">{{ $productgroup->pdt_group_name }}</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-6 pl-10">
            <div class="item-image">
                <img src="{{ $floorplan->images[0]['pic_url'] }}" alt="{{ $floorplan->images[0]['pic_name'] }}">
            </div>
            <p class="mt-2 mb-5 h2">{{ $floorplan->plan_description }}</p>
            <p>{{ $floorplan->plan_additional_text }}</p>
            <hr>
            @include('contractor.includes.items', ['contractor' => $contractor, 'floorplan' => $floorplan, 'subdomain' => $subdomain])
            <div class="d-flex justify-content-between">
                <a href="{{ route('contractor.pdf.create', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id]) }}" class="btn text-white mr-10" style="background-color:gray;">Download PDF</a>
                <a href="{{ route('contractor.email.create', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id]) }}" class="btn text-white" style="background-color:gray;">Email Us Your Option</a>
            </div>
        </div>
    </div>
</div>

@include("contractor.includes.item-single")
@include("contractor.includes.item-list", ['contractor' => $contractor, 'floorplan' => $floorplan])
@endsection