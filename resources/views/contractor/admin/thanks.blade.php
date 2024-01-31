@extends("contractor.admin.layouts.default")

@section("content")


@php
$domain = $contractor->sub_domain . "." . config('app.domain');
@endphp

<div class="main-content container">
    <!--begin::Card-->
    <div class=" card card-custom mt-6">
        <div class="card-header flex-wrap border-0 mt-20 thanks-header">
            <div class="card-title">
                <h3 class="card-label thanks-title">Thanks for signing up with myplanbase.com!</h3>
            </div>
        </div>
        <div class="card-body thanks-content">
            <div class="d-flex justify-content-center">
                <p>Your personalized website for customers to choose floor plans and options is now live at:&nbsp;&nbsp;&nbsp;<a href="/">{{ $domain}}</a></p>
            </div>
            <div class="d-flex justify-content-center">
                <p>Ask your website administrator to add a "Floor Plans" link from your website to:&nbsp;&nbsp;&nbsp;<a href="/">{{ $domain}}</a></p>
            </div>
            <div class="d-flex justify-content-center">
                <p>Please email us if you need help linking up your website.</p>
            </div>
            <div class="d-flex justify-content-center text-primary">
                <p>{{ "techsupport@" . config('app.domain') }}</p>
            </div>
        </div>
    </div>
    <!--end::Card-->
</div>
@endsection