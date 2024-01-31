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
@section("subheader")
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<style>
    .swiper {
        width: 100%;
        height: 100%;
    }

    .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .swiper-slide img {
        display: block;
        /* width: 100%; */
        height: 100%;
        object-fit: cover;
    }
    .swiper-button-next{
        color: gray;
    }
    .swiper-button-prev{
        color: gray;
    }
</style>

<div class="subheader py-2 py-lg-12 subheader-transparent" id="kt_subheader">
    <div class="container">
        <a href="{{ route('contractor.productgroups.index', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id]) }}" class="btn text-white btn-sm mb-5" style="background-color: grey;">
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
                    <a href="{{ route('contractor.productgroups.index', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id]) }}" class="text-dark text-hover-black opacity-75 hover-opacity-100">Options & Colors</a>
                    <span class="label label-dot label-sm bg-dark opacity-75 mx-3"></span>
                    <a href="" class="text-dark text-hover-black opacity-75 hover-opacity-100">{{ $productgroup->pdt_group_name }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container">
    <h1>
        <span>Options & Colors</span>
        <span class="label label-dot label-sm bg-dark mx-3"></span>
        <span>{{ $productgroup->pdt_group_name }}</span>
    </h1>
    <div class="row">
        <div class="col-md-6 border-right">
            <div class="row">
                @forelse ($products as $product)

                <div class="col-lg-4 col-md-6 col-sm-12 p-5">
                    <div class="card card-custom card-stretch">
                        <div class="card-body p-0 item-tiny-image product-image" data-name="{{ $product->pdt_name }}" data-description="{{ $product->pdt_description }}" data-image-list="{{ $product->images }}" data-additional-text="{{ $product->pdt_additional_text }}">
                            <img src="{{ $product->images[0]['pic_url'] }}" alt="{{ $product->images[0]['pic_name'] }}">
                        </div>
                        <div class="border-0 p-3">
                            <div class="mt-2 text-danger">{{ $product->pdt_name }}</div>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn text-white btn-sm py-1 px-2 select-product" style="background-color: grey;" data-product-id="{{ $product->id }}">Select</button>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="alert alert-warning w-100">No product</div>
                @endforelse
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
                <a href="{{ route('contractor.pdf.create', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id]) }}" class="btn text-white mr-10" style="background-color: grey;">Download PDF</a>
                <a href="{{ route('contractor.email.create', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id]) }}" class="btn text-white" style="background-color: grey;">Email Us Your Option</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="product-zoom-modal">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

@include("contractor.includes.item-single")
@include("contractor.includes.item-list")
@endsection