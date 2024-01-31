@php
    $tenant = App\Models\Tenant::find($cur_tenant_id);
    //$all_plans = App\Services\SubscriptionService::getAllPlans();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('admin.includes.head')
</head>
@yield('css')


<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    <!--begin::Main-->
    <!--begin::Header Mobile-->
    <div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
        <!--begin::Logo-->
        <a href="#" class="brand-logo">
            @if(isset($config_details->logo))
            <img src="{{ asset('uploads/client_logo/' . $config_details->logo) }}" style="width:100%;" alt="Logo">
            @else
            <img src="{{ asset('img/client/myplanbase_logo_white.png') }}" style="width:100%;" alt="Myplanbase Logo">
            @endif
        </a>
        <!--end::Logo-->
        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <!--begin::Aside Mobile Toggle-->
            <button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
                <span></span>
            </button>
            <!--end::Aside Mobile Toggle-->
            <!--begin::Header Menu Mobile Toggle-->
            <button class="btn p-0 btn-hover-text-primary ml-4" id="kt_header_mobile_toggle">
                <span>
                    <i class="fa fa-user fa-2x"></i>
                </span>
            </button>
            <!--end::Header Menu Mobile Toggle-->
        </div>
        <!--end::Toolbar-->
    </div>
    <!--end::Header Mobile-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="d-flex flex-row flex-column-fluid page">
            <!--begin::Aside-->
            @include('admin.includes.header')
            <!--end::Aside-->
            <!--begin::Wrapper-->
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                <!--begin::Header-->
                <div id="kt_header" class="header header-fixed">
                    <!--begin::Container-->
                    <div class="container-fluid d-flex align-items-stretch justify-content-end">
                        <!-- <div class="header-menu-wrapper-overlay"></div> -->
                        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
                            <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                                <ul class="menu-nav">
                                    <li class="menu-item menu-item-submenu menu-item-rel" aria-haspopup="true">
                                        <a style="background-color:#26A9DF;color:#fff;" href="" target="_blank" class="menu-link">
                                            <span class="menu-text" style="color:#fff;"><b>Support</b></span>
                                            <i class="menu-arrow"></i>
                                        </a>
                                    </li>

                                    <li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="click" aria-haspopup="true">
                                        <a href="{{ route('logout', ['subdomain' => $subdomain]) }}" class="menu-link">
                                            <span class="menu-text">Logout</span>
                                            <i class="menu-arrow"></i>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Header-->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    @if($tenant->upgrade_stripe_price && isset($all_plans[$tenant->upgrade_stripe_price]))
                    <div class="container justify-content-center">
                        <div class="alert alert-info" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <p>Please upgrade your Billing Price Plan to <strong>{{  $all_plans[$tenant->upgrade_stripe_price] }}</strong></p>
                        </div>
                    </div>
                    @endif
                    @yield('content')
                </div>
                <!--end::Content-->
                <!--begin::Footer-->
                @include('admin.includes.footer')
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Main-->

    <!--start::Terms Modal-->
    <div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="subscriptionModalLabel">Software License & Agreement</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-check col-md-12 p-0">
                        <p>This Services Agreement for Myplanbase Client Portal SaaS Product (the "Agreement") is made and entered into by and between you ("Client"), and Goldenfarb Copeland FV Software Ventures, LLC d/b/a “myplanbase”, a Florida corporation having its principal place of business at 275 Toney Penna Dr. Suite 8, Jupiter, FL 33458 ("myplanbase"), collectively referred to as the "Parties."</p>
                        <h5>RECITALS</h5>
                    </div>
                    <div class="form-check col-md-12 ">
                        <input class="form-check-input" type="checkbox" id="terms_check">
                        <label style="font-size:14px;" class="ml-1" for="terms_check">
                            I've read the terms.
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <p class="terms-error"></p>
                    <button type="button" class="btn btn-primary terms-btn" data-target="agree">I AGREE</button>
                    <button type="button" class="btn btn-secondary terms-btn" data-target="disagree">I DISAGREE</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Terms Modal-->

    <script>
        var HOST_URL = "";
    </script>
    <!--begin::Global Config(global config for global JS scripts)-->
    <script>
        var KTAppSettings = {
            "breakpoints": {
                "sm": 576,
                "md": 768,
                "lg": 992,
                "xl": 1200,
                "xxl": 1400
            },
            "colors": {
                "theme": {
                    "base": {
                        "white": "#ffffff",
                        "primary": "#3699FF",
                        "secondary": "#E5EAEE",
                        "success": "#1BC5BD",
                        "info": "#8950FC",
                        "warning": "#FFA800",
                        "danger": "#F64E60",
                        "light": "#E4E6EF",
                        "dark": "#181C32"
                    },
                    "light": {
                        "white": "#ffffff",
                        "primary": "#E1F0FF",
                        "secondary": "#EBEDF3",
                        "success": "#C9F7F5",
                        "info": "#EEE5FF",
                        "warning": "#FFF4DE",
                        "danger": "#FFE2E5",
                        "light": "#F3F6F9",
                        "dark": "#D6D6E0"
                    },
                    "inverse": {
                        "white": "#ffffff",
                        "primary": "#ffffff",
                        "secondary": "#3F4254",
                        "success": "#ffffff",
                        "info": "#ffffff",
                        "warning": "#ffffff",
                        "danger": "#ffffff",
                        "light": "#464E5F",
                        "dark": "#ffffff"
                    }
                },
                "gray": {
                    "gray-100": "#F3F6F9",
                    "gray-200": "#EBEDF3",
                    "gray-300": "#E4E6EF",
                    "gray-400": "#D1D3E0",
                    "gray-500": "#B5B5C3",
                    "gray-600": "#7E8299",
                    "gray-700": "#5E6278",
                    "gray-800": "#3F4254",
                    "gray-900": "#181C32"
                }
            },
            "font-family": "Poppins"
        };
    </script>
    <!--end::Global Config-->
    <!--begin::Global Theme Bundle(used by all pages)-->
    <script src="{{ asset('js/plugins.bundle.js') }}"></script>
    <script src="{{ asset('js/prismjs.bundle.js') }}"></script>
    <script src="{{ asset('js/scripts.bundle.js') }}"></script>
    <!--end::Global Theme Bundle-->
    <!--begin::Page Vendors(used by this page)-->
    <script src="{{ asset('js/fullcalendar.bundle.js') }}"></script>
    <script src="{{ asset('js/datatables.bundle.js') }}"></script>
    <!--end::Page Vendors-->
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{ asset('js/widgets.min.js') }}"></script>
    <!--end::Page Scripts-->

    <script src="{{ asset('js/select2.js') }}"></script>


    <!--Custom JavaScript -->
    <script src="{{ asset('../js/admin/custom.js') }}"></script>
    <!--flot chart-->
    {{-- <script src="{{ asset('js/jquery.flot.js') }}"></script>
    <script src="{{ asset('js/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('js/jquery.flot.time.js') }}"></script> --}}
    <script src="{{ asset('../js/dashboard1.js') }}"></script>
    <script src="{{ asset('../js/checkout.js') }}"></script>

    @if(request()->is('admin/support') )
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('js/lightbox.min.js') }}"></script>
    @endif

    <script src="{{ asset('js/html-table.min.js') }}"></script>

    @if(request()->is('admin/mass_messages') )
    <script src="{{ asset('../js/mass_messages.js') }}"></script>
    @endif

    @if(request()->is('admin/phase_mapping') )
    <script src="{{ asset('../js/phase_mapping.js') }}"></script>
    @endif
    @if(request()->is('admin/phase_categories') )
    <script src="{{ asset('../js/phase_category.js') }}"></script>
    @endif


    @if(request()->is('admin/webhooks') )
    <script src="{{ asset('../js/webhook.js') }}"></script>
    @endif

    @if(request()->is('admin/mass_updates') )
    <script src="{{ asset('../js/contact.js') }}"></script>
    @endif

    @if(request()->is('admin/phase_change_automated_communications'))
    <script src="{{ asset('../js/automated_communication.js') }}"></script>
    @endif
    @if(request()->is('admin/google_review_automated_communications'))
    <script src="{{ asset('../js/google_review.js') }}"></script>
    @endif

    @yield('scripts')

    <!--begin::Check if tenant has not accepted terms already -->
    @if($tenant && !$tenant->is_accept_license && 1==2)
    <script>
        $(document).ready(function() {
            $('#termsModal').modal('show');

            // change terms status
            $(document).on('click', '.terms-btn', function() {
                $('.terms-error').removeClass('text-danger');
                $('.terms-error').text('');
                // check for checkbox
                var terms_check = $('#terms_check').prop('checked');
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var tenant_id = "{{$tenant->id}}";
                var status = $(this).attr('data-target');

                if(!terms_check && status == 'agree') {
                    $('.terms-error').addClass('text-danger');
                    $('.terms-error').text('Please tick accept checkbox');
                    return false;
                }


                $('.terms-error').text('PROCESSING....');
                // send ajax request
                $.ajax({
                    url: "{{url('admin/accept_terms')}}",
                    type: 'POST',
                    data: {
                        '_token': CSRF_TOKEN,
                        'tenant_id': tenant_id,
                        'status': status
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        location.reload();
                    },
                    error: function() {
                        $('.terms-error').text('');
                    }
                });
            });

        });
    </script>
    @endif
    <!--end::Check if tenant has not accepted terms already -->

</body>
<!--end::Body-->

</html>
