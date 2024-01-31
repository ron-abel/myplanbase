@extends('contractor.layouts.default')

@php
$name = $floorplan->pivot->is_keep_same_name == 1 ? $floorplan->plan_name : $floorplan->pivot->floor_plan_rename;
$price = $floorplan->pivot->floor_plan_price ? $floorplan->pivot->floor_plan_price : 0;
@endphp

@section("subheader")
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    .box-thumbnail{
    transition: box-shadow .3s !important;
}
.box-thumbnail:hover{
    box-shadow: 0 0 11px rgba(33,33,33,.2) !important;
}
img {
      transition: transform 0.3s ease-in-out;
      cursor: pointer;
    }

    .enlarged {
      transform: scale(1.4);
    }
</style>
<div class="subheader py-2 py-lg-12 subheader-transparent" id="kt_subheader">
    <div class="container">
        <div class="d-flex justify-content-between">
            <a href="{{ route('contractor.floorplans.index', ['subdomain' => $subdomain]) }}" class="btn text-white btn-sm mb-5" style="background-color: grey;">
                <i class="las la-arrow-left text-white"></i>
                <span>Back</span>
            </a>
            <a href="{{ route('contractor.productgroups.index', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id]) }}" class="btn text-white btn-sm mb-5" style="background-color: grey;">Options & Colors</a>
        </div>
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex flex-column">
                <div class="d-flex align-items-center font-weight-bold my-2">
                    <span class="label label-dot label-sm bg-dark opacity-75 mx-3"></span>
                    <a href="{{ route('contractor.floorplans.index', ['subdomain' => $subdomain]) }}" class="text-dark text-hover-black opacity-75 hover-opacity-100">Floor Plans</a>
                    <span class="label label-dot label-sm bg-dark opacity-75 mx-3"></span>
                    <a href="" class="text-dark text-hover-black opacity-75 hover-opacity-100">{{ $name }}</a>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-6 pr-30 border-right">
            <div class="card card-custom card-stretch box-thumbnail">
                <div class="card-body p-0 item-image">
                    <img src="{{ $floorplan->images[0]['pic_url'] }}" onclick="toggleSize(this)" alt="{{ $floorplan->images[0]['pic_name'] }}">
                </div>
                
                <div class="card-header border-0 p-5">
                    <div class="card-title">
                        <div class="card-label">
                            <div class="h2" style="color:gray;">{{ $floorplan->plan_description }}</div>
                            <div class="font-size-sm mt-3" style="color:#A9A9A9">{{ $floorplan->plan_additional_text }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="row pl-20">
                <div class="col-12 d-flex justify-content-end">
                    <div class="row">
                        @foreach($floorplan->videos as $video)
                        @if(count($floorplan->videos) == 1)
                        <a href="#"  class="m-1 btn text-white floorplan-video" data-src="{{ $video['vid_url'] }}" data-alt="{{ $video['vid_name'] }}" style="background-color: gray; min-width:172px;"><i class="fa fa-play text-white"></i> Video {{$video['vid_name']}}</a>
                        @elseif(count($floorplan->videos) == 2)
                        <div class="col-md-6 d-flex justify-content-end" >
                            <a href="#"  class="mt-1 ml-1 btn text-white floorplan-video" data-src="{{ $video['vid_url'] }}" data-alt="{{ $video['vid_name'] }}" style="background-color: gray; min-width:175px;"><i class="fa fa-play text-white"></i> Video {{$video['vid_name']}}</a>
                        </div>
                        @else
                        <div class="col-md-4 d-flex justify-content-end" >
                            <a href="#"  class="mt-1 ml-1 btn text-white floorplan-video" data-src="{{ $video['vid_url'] }}" data-alt="{{ $video['vid_name'] }}" style="background-color: gray; min-width:130px;"><i class="fa fa-play text-white"></i> Video {{$video['vid_name']}}</a>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                @foreach ($floorplan->images as $image)
                @php
                $src = $image['pic_url'];
                $alt = $image['pic_name'];
                @endphp
                <div class="col-sm-6 py-5">
                    <div class="item-small-image floorplan-image" data-src="{{ $src }}" data-alt="{{ $alt }}">
                        <img src="{{ $src }}" alt="{{ $alt }}">
                    </div>
                    <div class="mt-2 text-center">{{ $alt }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="floorplan-zoom-modal">
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
<script>
  function toggleSize(element) {
    element.classList.toggle('enlarged');
  }
</script>
@endsection