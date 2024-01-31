@extends("contractor.admin.layouts.default")

@section("content")
<div class="main-content container">
    <!--begin::Card-->
    <div class="card card-custom mt-6">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">STEP 2 - CHOOSE WHICH PRODUCT GROUPS YOU WANT TO OFFER.</h3>
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

            <p>
                Product groups are Groups of products, like CABINETS, or WINDOWS. In the next screen you will choose the options within those groups, like windows colors and styles, etc.<br>
                If you only want to display limited products and don't need to group them, you can skip this step and go straight to the next page, BUT, your products would not be organized by group
            </p>
            <a href="{{ route('contractor.admin.products.index', ['subdomain' => $subdomain]) }}" class="btn btn-secondary my-3 mb-5">I DON'T NEED PRODUCT GROUPING - GO STRAIGHT TO PRODUCTS</a>
            
            <div class="form-group row d-flex align-items-center">
                <div class="col m-0" style="max-width:fit-content;">
                    <span class="switch switch-outline switch-icon switch-success">
                        <label>
                            <input type="checkbox" id="product-groups-filter" />
                            <span></span>
                        </label>
                    </span>
                </div>
                <label class="col font-weight-bold m-0" style="max-width:fit-content;">Only My Product Groups</label>
            </div>

            <div class="row">
                @forelse ($productgroups as $productgroup)
                @php
                $selected = in_array($contractor->id, Arr::pluck($productgroup->contractors, "id"));
                @endphp
                <div class="col-lg-4 col-md-6 col-sm-12 p-10  product-group-box {{ $productgroup->contractor_id == Auth::user()->id ? 'my-product-group-box' : '' }}">
                    <div class="d-flex">
                        <div class="item-card {{ $selected ? 'selected' : '' }}">
                            <div class="item-image">
                                <img src="{{ $productgroup->images[0]['pic_url'] }}" alt="{{ $productgroup->images[0]['pic_name'] }}">
                            </div>
                            <div class="item-card-body">
                                <div class="row mt-2">
                                    <div class="col">
                                        <p>{{ $productgroup->pdt_group_name }}</p>
                                    </div>
                                    <div class="col d-flex justify-content-end align-items-start">
                                        <button type="button" class="btn open-more-modal text-primary p-0" data-name="{{ $productgroup->pdt_group_name  }}" data-title="{{ $productgroup->pdt_group_description }}" data-description="{{ $productgroup->pdt_group_additional_text }}">
                                            More Info
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item-buttons">
                            <button type="button" class="btn btn-sm btn{{ !$selected ? '' : '-outline' }}-danger select-item" data-status="0" data-url="{{ route('contractor.admin.productgroups.update_selection', ['subdomain' => $subdomain, 'productgroup' => $productgroup->id]) }}"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-sm btn{{ $selected ? '' : '-outline' }}-success select-item mb-2" data-status="1" data-url="{{ route('contractor.admin.productgroups.update_selection', ['subdomain' => $subdomain, 'productgroup' => $productgroup->id]) }}"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="alert alert-warning w-100">No product group</div>
                @endforelse
            </div>

            <div class="d-flex justify-content-between">
                <div class="d-flex justify-content-end m-5">
                    <a href="{{ route('contractor.admin.productgroups.list', ['subdomain' => $subdomain]) }}" class="btn btn-primary font-weight-bolder align-self-start">Upload your own Product Groups</a>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('contractor.admin.products.index', ['subdomain' => $subdomain]) }}" class="btn btn-primary m-5">I"M DONE, SAVE MY SELECTIONS & GO TO NEXT STEP</a>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->
</div>

<form method="POST" id="select-item-form">
    @csrf
    @method('PUT')
    <input type="hidden" name="status">
</form>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $(document).on('change', '#product-groups-filter', function() {
                if($(this).prop('checked')) {
                    $('.product-group-box').fadeOut();
                    $('.my-product-group-box').fadeIn(500);
                }
                else {
                    $('.product-group-box').fadeIn(500);
                }
            })
        });
    </script>
    @endsection