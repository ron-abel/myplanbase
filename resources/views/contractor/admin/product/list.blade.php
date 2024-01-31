@extends("contractor.admin.layouts.default")

@section("content")
<div class="main-content container">
    <!--begin::Card-->
    <div class=" card card-custom mt-6">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Products</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <a href="{{ route('contractor.admin.products.create', ['subdomain' => $subdomain]) }}" class="btn btn-primary font-weight-bolder">
                    <i class="icon-xl la la-plus"></i>
                    Add Product
                </a>
                <!--end::Button-->
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
                        <div class="dropdown">
                            <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown">
                                {{ is_null($productgroup) ? "ALL PRODUCT GROUP" : $productgroup->pdt_group_name }}
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('contractor.admin.products.list', ['subdomain' => $subdomain]) }}">ALL PRODUCT GROUP</a>
                                @foreach ($productgroups as $productgroup)
                                <a class="dropdown-item" href="{{ route('contractor.admin.products.list', ['productgroup' => $productgroup->id, 'subdomain' => $subdomain]) }}">{{ $productgroup->pdt_group_name }}</a>
                                @endforeach
                            </div>
                        </div>
                        <th></th>
                        <th title="Field #2">Product Name</th>
                        <th title="Field #2">Product Images</th>
                        <th title="Field #3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->productgroup->pdt_group_name }}</td>
                        <td>{{ $product->pdt_name }}</td>
                        <td>
                            <div class="preview-image">
                                <img class="img-thumbnail" src="{{ $product->images[0]['pic_url'] }}" alt="pic2 image">
                            </div>
                        </td>
                        <td class="d-flex justify-content-end">
                            <a href="{{ route('contractor.admin.products.edit', ['product' => $product->id, 'subdomain' => $subdomain]) }}" class="btn btn-sm btn-clean btn-icon"><i class="icon-xl la la-pen"></i></a>
                            <a href="{{ route('contractor.admin.products.destroy', ['product' => $product->id, 'subdomain' => $subdomain]) }}" class="btn btn-sm btn-clean btn-icon delete"><i class="icon-xl la la-trash-o"></i></a>
                        </td>
                    </tr>
                    @empty
                    <!-- <div class="alert alert-warning">No product</div> -->
                    @endforelse
                </tbody>
            </table>
            <!--end: Datatable-->
        </div>
    </div>
    <!--end::Card-->
</div>
@endsection