@extends("superadmin.layouts.default")

@section('content')
<div class="main-content container">
    <div class="row mt-6">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Add Contractor</h3>
                </div>
                <!--begin::Form-->
                <form action="{{ route('super.contractors.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @if ( session()->has('error') )
                    <div>{{ session()->get('error') }}</div>
                    @endif

                    <div class="card-body">
                        @include('superadmin.contractor.form', ['contractor' =>
                            [
                                'company_name' => '',
                                'company_website' => '',
                                'sub_domain' => '',
                                'address' => '',
                                'state' => '',
                                'country' => '',
                                'zip' => '',
                                'business_description' => '',
                                'logo' => '',
                            ]
                        ])
                        <div class="d-flex justify-content-end mt-10">
                            <button type="submit" class="btn btn-primary">Save</button>
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