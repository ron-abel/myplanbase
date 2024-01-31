@extends("contractor.admin.layouts.default")

@section("content")

@php
if($errors->any())
echo "<script>
    window.showModal = true;
</script>";
@endphp

<div class="main-content container">
    <!--begin::Card-->
    <div class=" card card-custom mt-6">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">STEP 1 - CHOOSE WHICH FLOOR PLANS YOU WANT TO OFFER</h3>
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
                If you don't want to order any of our floor plans, and use the product selection feature only, choose this link :
                <a href="{{ route('contractor.admin.productgroups.index', ['subdomain' => $subdomain]) }}">Product Selection Feature Only</a> .
            </p>

            <div class="form-group row d-flex align-items-center">
                <div class="col m-0" style="max-width:fit-content;">
                    <span class="switch switch-outline switch-icon switch-success">
                        <label>
                            <input type="checkbox" id="plans-filter" />
                            <span></span>
                        </label>
                    </span>
                </div>
                <label class="col font-weight-bold m-0" style="max-width:fit-content;">Only My Plans</label>
            </div>

            <div class="row">
                @forelse ($floorplans as $floorplan)
                @php
                $selected = in_array($contractor->id, Arr::pluck($floorplan->contractors, "id"));

                $floor_plan_price = "";
                $is_keep_same_name = "";
                $floor_plan_rename = "";
                $is_not_display_price = "";

                if($selected) {
                $values = $floorplan->contractors()->where('contractor_id', $contractor->id)->withPivot('floor_plan_price', 'is_keep_same_name', 'floor_plan_rename', 'is_not_display_price')->first();

                $floor_plan_price = $values['pivot']['floor_plan_price'];
                $is_keep_same_name = $values['pivot']['is_keep_same_name'];
                $floor_plan_rename = $values['pivot']['floor_plan_rename'];
                $is_not_display_price = $values['pivot']['is_not_display_price'];
                }
                @endphp
                <div class="col-lg-4 col-md-6 col-sm-12 p-10 floor-plan-box {{ $floorplan->contractor_id == Auth::user()->id ? 'my-floor-plan-box' : '' }}">
                    <div class="d-flex">
                        <div class="item-card {{ $selected ? 'selected' : '' }}">
                            <div class="item-image">
                                <img src="{{ $floorplan->images[0]['pic_url'] }}" alt="{{ $floorplan->images[0]['pic_name'] }}">
                            </div>
                            <div class="item-card-body">
                                <div class="row mt-2">
                                    <div class="col">
                                        <p>{{ $floorplan->plan_name }}</p>
                                    </div>
                                    <div class="col d-flex justify-content-end align-items-start">
                                        <button type="button" class="btn open-more-modal text-primary p-0" data-name="{{ $floorplan->plan_name  }}" data-title="{{ $floorplan->plan_description }}" data-description="{{ $floorplan->plan_additional_text }}">
                                            More Info
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item-buttons">
                            <button type="button" class="btn btn-sm btn{{ !$selected ? '' : '-outline' }}-danger select-item" data-status="0" data-url="{{ route('contractor.admin.floorplans.update_selection', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id]) }}"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-sm btn{{ $selected ? '' : '-outline' }}-success open-select-modal mb-2" data-title="{{ $floorplan->plan_name }}" data-url="{{ route('contractor.admin.floorplans.update_selection', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id]) }}" data-price="{{ $floor_plan_price }}" data-rename="{{ $floor_plan_rename }}" data-keepname="{{ $is_keep_same_name }}" data-notdisplayprice="{{ $is_not_display_price }}">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="alert alert-warning w-100">No floor plan</div>
                @endforelse
            </div>
            <!--end: Datatable-->

            <div class="d-flex justify-content-between">
                <div class="d-flex justify-content-end m-5">
                    <a href="{{ route('contractor.admin.floorplans.list', ['subdomain' => $subdomain]) }}" class="btn btn-primary font-weight-bolder align-self-start">Upload your own Floor Plan</a>
                </div>
                <div class="d-flex justify-content-end m-5">
                    <a href="{{ route('contractor.admin.productgroups.index', ['subdomain' => $subdomain]) }}" class="btn btn-primary font-weight-bolder">
                        I'm done, Save my selections
                    </a>
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


    <!-- Floor Plan Additional Popup -->
    <div class="modal fade" id="floor-plan-select-setting-modal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">
                        @if (session()->has('planName'))
                        {{ session()->get('planName') }}
                        @endif
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form method="POST" action="{{ session()->has('prevUrl') ? session()->get('prevUrl') : '' }}">
                        @csrf
                        @method("PUT")
                        <p class="my-4">If you want, you can choose your own name for this floor plan:</p>
                        <div class="row mb-5">
                            <div class="col">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input @error('is_keep_same_name') is-invalid @enderror" id="keepname" name="is_keep_same_name" value="1" {{ old('is_keep_same_name') == "1" ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="keepname">Keep the same name.</label>
                                    @error('is_keep_same_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input @error('is_keep_same_name') is-invalid @enderror" id="rename" name="is_keep_same_name" value="0" {{ old('is_keep_same_name') == "0" ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="rename">Rename the floor plan.</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label for="new_name">New floor plan name :</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control @error('floor_plan_rename') is-invalid @enderror" id="new_name" name="floor_plan_rename" value="{{ old('floor_plan_rename') }}">
                                @error('floor_plan_rename')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <p class="my-4">You can enter a price you want to charge for this home (NOT RECOMMENDED)</p>
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input @error('is_not_display_price') is-invalid @enderror" id="not-display-price" name="is_not_display_price" value="1" {{ old('is_not_display_price') == "1" ? 'checked' : '' }}>
                            <label class="custom-control-label" for="not-display-price">Don't display price (RECOMMENDED)</label>
                        </div>
                        @error('is_not_display_price')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                        <div class="d-flex align-items-start mt-6">
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input @error('is_not_display_price') is-invalid @enderror" id="allowprice" name="is_not_display_price" value="1" {{ old('is_not_display_price') == "0" ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="allowprice">Enter a price for this home:</label>
                                </div>
                                @error('is_not_display_price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group ml-12">
                                <input type="number" class="form-control @error('floor_plan_price') is-invalid @enderror" name="floor_plan_price" value="{{ old('floor_plan_price') }}" min="0">
                                @error('floor_plan_price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary ml-auto" style="height: auto;">SAVE</button>
                        </div>
                        <input type="hidden" name="status" value="1">
                    </form>
                </div>
            </div>
        </div>
    </div>


    @endsection

    @section('scripts')
    <script>
        $(document).ready(function () {
            $(document).on('change', '#plans-filter', function() {
                if($(this).prop('checked')) {
                    $('.floor-plan-box').fadeOut();
                    $('.my-floor-plan-box').fadeIn(500);
                }
                else {
                    $('.floor-plan-box').fadeIn(500);
                }
            })
        });
    </script>
    @endsection