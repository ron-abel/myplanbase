<div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
    <!--begin::Container-->
    <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
        <!--begin::Copyright-->
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted font-weight-bold mr-2">{{ date('Y') }}©</span>
            <a href="#" target="_blank" class="text-dark-75 text-hover-primary">Myplanbase</a>
        </div>
        <!--end::Copyright-->
        <!--begin::Nav-->
        <div class="nav nav-dark order-1 order-md-2">
            <a href="http://keenthemes.com/metronic" target="_blank" class="nav-link pr-3 pl-0">About</a>
            <a href="http://keenthemes.com/metronic" target="_blank" class="nav-link px-3">Team</a>
            <a href="http://keenthemes.com/metronic" target="_blank" class="nav-link pl-3 pr-0">Contact</a>
        </div>
        <!--end::Nav-->
    </div>
    <!--end::Container-->
</div>
<script>
    function go_to_cart_page(_self) {
        let count = $(_self).attr('data-count');
        let url = $(_self).attr('data-href');
        if(count > 0) {
            location.href = url;
        }
        else {
            alert('There are not any items in your cart now. Please add your items!');
        }
    }
</script>