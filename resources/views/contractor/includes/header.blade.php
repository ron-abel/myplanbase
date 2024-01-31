<div id="kt_header" class="header header-fixed bg-white">
    <!--begin::Container-->
    <div class="container d-flex align-items-stretch">
        <!--begin::Left-->
        <div class="d-flex align-items-stretch flex-grow-1 border-bottom">
            <!--begin::Header Logo-->
            <div class="header-logo">
                <a href="#">
                    @isset($contractor->logo)
                    <img src="{{ $contractor->logo }}" class="logo-default max-h-40px" alt="Logo">
                    <img src="{{ $contractor->logo }}" class="logo-sticky max-h-40px" alt="Logo">
                    @else
                    <img src="{{ asset('img/client/cropped-zipkit-logo.png') }}" class="logo-default max-h-40px" alt="Myplanbase Logo">
                    <img src="{{ asset('img/client/cropped-zipkit-logo.png') }}" class="logo-sticky max-h-40px" alt="Myplanbase Logo">
                    @endif
                </a>
            </div>
            <!--end::Header Logo-->
            <!--begin::Header Menu Wrapper-->
            <div class="header-menu-wrapper header-menu-wrapper-left ml-auto" id="kt_header_menu_wrapper">
                <!--begin::Header Menu-->
                <div id="kt_header_menu" class="header-menu header-menu-left header-menu-mobile header-menu-layout-default">
                    <!--begin::Header Nav-->
                    <ul class="menu-nav">
                        <li class="menu-item menu-item-submenu menu-item-rel {{ request()->route()->getName()=='contractor.home' ? 'menu-item-here': '' }}">
                            <a href="{{ route('contractor.home', ['subdomain' => $subdomain]) }}" class="menu-link">
                                <span class="menu-text">Back to builders page</span>
                            </a>
                        </li>
                        <li class="menu-item menu-item-submenu menu-item-rel {{ request()->route()->getName()=='contractor.floorplans.index' ? 'menu-item-here': '' }}">
                            <a href="{{ route('contractor.floorplans.index', ['subdomain' => $subdomain]) }}" class="menu-link">
                                <span class="menu-text">Floor plans</span>
                            </a>
                        </li>
                        <li class="menu-item menu-item-submenu menu-item-rel">
                            <a href="#" class="menu-link">
                                <span class="menu-text">About</span>
                            </a>
                        </li>
                        <li class="menu-item menu-item-submenu menu-item-rel">
                            <a href="#" class="menu-link">
                                <span class="menu-text">Contact us</span>
                            </a>
                        </li>
                        <li class="menu-item menu-item-submenu menu-item-rel">
                            @php
                            $cart_item = \App\Helpers\ManageItems::get_last_floor_plan($subdomain);
                            @endphp
                            <button data-href="{{ $cart_item['url'] }}" data-count="{{ $cart_item['count'] }}" class="menu-link nav-cart-button btn text-white btn-hover-white btn-hover-text-dark" style="background-color:gray;    border-color: gray !important;" onclick="go_to_cart_page(this)">
                                <span class="icon-xl las la-shopping-cart"></span>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>