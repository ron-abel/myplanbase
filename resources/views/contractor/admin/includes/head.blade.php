<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title')</title>

<link rel="canonical" href="https://keenthemes.com/metronic" />
<link href="{{ asset('img/favicon.png') }}" rel="shortcut icon" type="image/png">

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
<link href="{{ asset('css/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ asset('../css/custom.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('../css/slideshow.css') }}" rel="stylesheet" type="text/css" />
<meta charset="utf-8">

<link href="{{ asset('css/style.bundle.admin.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/lightbox.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/header/base/light.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/header/menu/light.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/brand/dark.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/aside/dark.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('../css/admin/custom.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/wizard.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="{{ asset('css/themify-icons.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css" />
<style>
    .bg-info-error {
        background-color: #0f2c4d !important;
    }

    .hidden-input {
        display: none;
    }
</style>
<!------ChartJS----->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
<!-- Tiny MCE script -->
<script src="https://cdn.tiny.cloud/1/{{env('TINY_MCE_KEY')}}/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>