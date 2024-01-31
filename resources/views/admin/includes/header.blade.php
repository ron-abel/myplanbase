<?php
// $config_details = DB::table('config')
//     ->where('tenant_id', $cur_tenant_id)
//     ->first();
$user = Auth::user();
// $permissions = DB::table('user_role_permissions')
//     ->where('user_role_id', $user->user_role_id)
//     ->where('is_allowed', 1)
//     ->get()
//     ->pluck('tenant_admin_page')
//     ->toArray();
?>
<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside" style="overflow-y:auto;">
    <!--begin::Brand-->
    <div class="brand flex-column-auto justify-content-between" id="kt_brand">
        <p>&nbsp;</p>
        <!--begin::Logo-->
        <a href="#" class="brand-logo">
            @if (isset($config_details->logo))
                <img src="{{ asset('uploads/client_logo/' . $config_details->logo) }}"
                    style="width:100%; max-height:65px;" alt="Logo">
            @else
                <img src="{{ asset('img/client/cropped-zipkit-logo.png') }}" style="width:100%; max-height:65px;"
                    alt="Myplanbase Logo">
            @endif
        </a>
        <!--end::Logo-->
        <!--begin::Toggle-->
        <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
            <span class="text-white">
                <i class="fa fa-angle-double-left fa-2x"></i>
            </span>
        </button>
        <!--end::Toolbar-->
    </div>
    <!--end::Brand-->
    <!--begin::Aside Menu-->
    <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
        <!--begin::Menu Container-->
        <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1"
            data-menu-dropdown-timeout="500">
            <!--begin::Menu Nav-->
            <ul class="menu-nav">
                <li class="menu-item {{ request()->is('admin/dashboard') ? 'menu-item-active' : '' }} "
                    aria-haspopup="true">
                    <a href="{{ route('dashboard', ['subdomain' => $subdomain]) }}" class="menu-link">
                        <span class="menu-icon">
                            <i class="fa-icon far fa-clock"></i>
                        </span>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>
            </ul>
            <!--end::Menu Nav-->
        </div>
        <!--end::Menu Container-->
    </div>
    <!--end::Aside Menu-->
</div>
