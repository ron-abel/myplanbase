@extends("contractor.admin.layouts.default")

@section("content")
<div class="main-content container">
    <!--begin::Card-->
    <div class=" card card-custom mt-6">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Customer Detail</h3>
            </div>
        </div>
        <div class="card-body">
            <h4 class="my-3">Customer Info</h4>
            <div class="row customer-detail">
                <div class="col-sm-4">Source Website :</div>
                <div class="col-sm-8">{{ $customer->source_website }}</div>
                <div class="col-sm-4">Customer Name :</div>
                <div class="col-sm-8">{{ $customer->name }}</div>
                <div class="col-sm-4">Customer Email :</div>
                <div class="col-sm-8">{{ $customer->email }}</div>
                <div class="col-sm-4">Customer Phone :</div>
                <div class="col-sm-8">{{ $customer->phone }}</div>
                <div class="col-sm-4">Home Location :</div>
                <div class="col-sm-8">{{ $customer->home_location }}</div>
                <div class="col-sm-4">Home State :</div>
                <div class="col-sm-8">{{ $customer->home_state }}</div>
                <div class="col-sm-4">Home Zip :</div>
                <div class="col-sm-8">{{ $customer->home_zip }}</div>
            </div>
            <h4 class="my-3">Floor plan chosen</h4>
            @foreach ($submits as $submit)
            @php
            $floorplan = $submit->floorplan;
            @endphp
            <div class="row">
                <div class="col-sm-4">{{ $floorplan['plan_name'] }}</div>
                <div class="col-sm-8">
                    <img src="{{ $floorplan->images[0]['pic_url'] }}" width="100" height="100" class="img-thumbnail">
                </div>
            </div>
            @endforeach
            <h4 class="my-3">Products chosen</h4>
            <div class="row my-3">
                <div class="col-sm-2 h6">Image</div>
                <div class="col-sm-2 h6">Product Group</div>
                <div class="col-sm-2 h6">Option Chosen</div>
                <div class="col-sm-6 h6">Customer Comment</div>
            </div>
            @foreach ($submit_products as $submit_product)
            @php
            $product = $submit_product->product;
            @endphp
            <div class="row">
                <div class="col-sm-2">
                    <img src="{{ $product['images'][0]['pic_url'] }}" width="100" height="100" class="img-thumbnail">
                </div>
                <div class="col-sm-2">{{ $product->productgroup['pdt_group_name'] }}</div>
                <div class="col-sm-2">{{ $product['pdt_name'] }}</div>
                <div class="col-sm-6">{{ $submit_product->customer_comment }}</div>
            </div>
            @endforeach
            <h4 class="my-3">Note</h4>
            <p>{{ $customer->note }}</p>
        </div>
    </div>
    <!--end::Card-->
</div>

@endsection