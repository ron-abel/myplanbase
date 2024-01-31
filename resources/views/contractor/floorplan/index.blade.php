@extends('contractor.layouts.default')

@section("content")
<div class="container mt-10">
    <h1 class="mb-5">Floor Plans</h1>
    <div class="row">
        @foreach ($floorplans as $floorplan)
        <div class="col-lg-4 col-md-6 col-12 p-10">
            <a class="card card-custom card-stretch" href="{{ route('contractor.floorplans.show', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id]) }}">
                <div class="card-body p-0 item-image">
                    <img src="{{ $floorplan->images[0]['pic_url'] }}" alt="{{ $floorplan->images[0]['pic_name'] }}">
                </div>
                <div class="card-header border-0 p-5">
                    <div class="card-title">
                        <div class="card-label">
                            <div class="font-weight-bolder">{{ $floorplan->pivot->is_keep_same_name == 1 ? $floorplan->plan_name : $floorplan->pivot->floor_plan_rename }}</div>
                            <div class="font-size-sm text-muted mt-2">{{ $floorplan->plan_description }}</div>
                            @unless ($floorplan->pivot->is_not_display_price == 1)
                            <div>${{ $floorplan->pivot->floor_plan_price ? $floorplan->pivot->floor_plan_price : 0 }}</div>
                            @endunless
                            <div class="card-link text-primary mt-5">View plans and options</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection