<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title')</title>

<link href="{{ asset('img/favicon.png') }}" rel="shortcut icon" type="image/png">

<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css?' . time()) }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css?' . time()) }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/fontawesome-all.min.css?' . time()) }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/main.css?' . time()) }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/main_client.css?' . time()) }}">
<link rel="stylesheet" type="text/css" href="{{ asset('../css/client/custom.css?' . time()) }}">
<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
