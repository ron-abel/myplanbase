@extends("contractor.admin.layouts.default")

@section("content")
<div class="main-content container-fluid">
    <!--begin::Card-->
    <div class=" card card-custom mt-6">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Customers</h3>
            </div>
        </div>
        <div class="card-body">
            @if (session()->has('success'))
            <div class="alert alert-primary" role="alert"> {{ session()->get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @elseif(session()->has('error'))
            <div class="alert alert-danger" role="alert"> {{ session()->get('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <div class="overlay loading d-none"></div>
            <div class="spinner-border text-primary loading d-none" role="status">
                <span class="sr-only">Loading...</span>
            </div>

            <!--begin::Search Form-->
            <div class="mb-7">
                <div class="row align-items-center">
                    <div class="col-lg-9 col-xl-8">
                        <div class="row align-items-center">
                            <div class="col-md-4 my-2 my-md-0">
                                <div class="input-icon">
                                    <input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query" />
                                    <span>
                                        <i class="flaticon2-search-1 text-muted"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Search Form-->
            <!--end: Search Form-->
            <!--begin: Datatable-->
            <table class="datatable datatable-bordered table-responsive datatable-head-custom" id="kt_datatable">
                <thead>
                    <tr>
                        <th title="Field #1">Name</th>
                        <th title="Field #2">Email</th>
                        <th title="Field #3">Phone</th>
                        <th title="Field #4">Home Location</th>
                        <th title="Field #5">Home State</th>
                        <th title="Field #6">Home Zip</th>
                        <th title="Field #7">Note</th>
                        <th title="Field #8">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customers as $customer)
                    <tr>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->home_location }}</td>
                        <td>{{ $customer->home_state }}</td>
                        <td>{{ $customer->home_zip }}</td>
                        <td>{{ $customer->note }}</td>
                        <td class="d-flex justify-content-end">
                            <a href="{{ route('contractor.admin.customers.show', ['subdomain' => $subdomain, 'customer' => $customer->id]) }}" class="btn btn-sm btn-clean btn-icon"><i class="icon-xl la la-search"></i></a>
                        </td>
                    </tr>
                    @empty
                    <!-- <div class="alert alert-warning">No product</div> -->
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!--end::Card-->
</div>

@endsection