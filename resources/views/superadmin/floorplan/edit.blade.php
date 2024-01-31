@extends('superadmin.layouts.default')

@section('content')
<div class="main-content container">
    <div class="row mt-6">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Edit Floor Plan</h3>
                </div>
                <!--begin::Form-->
                <form action="{{ route('super.floorplans.update', ['floorplan' => $floorplan->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")

                    @if ( session()->has('error') )
                    <div>{{ session()->get('error') }}</div>
                    @endif

                    <div class="card-body">
                        @include('superadmin.floorplan.form', ['floorplan' => $floorplan, 'image_cnt' => count($floorplan->images),'video_cnt' => count($floorplan->videos)])
                        <div class="d-flex justify-content-end mt-10">
                            <button type="submit" class="btn btn-primary">Update Floor Plan</button>
                        </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>
            <!--end::Card-->
        </div>
    </div>
</div>
@endsection