<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		@include('client.includes.head')
	</head>

	<body>
		@yield('content')

		{{-- <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
		<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script> --}}

	</body>
</html>
