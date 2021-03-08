<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">

	<!-- CSRF Token -->
	{{--<meta name="csrf-token" content="{{ csrf_token() }}">--}}

	<base href="{{ url('') }}">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<!-- <link href="{{ asset('theme/img/logo/logo.png') }}" rel="icon"> -->
	<title>{{ config('app.name', 'Laravel') }}</title>
	<link rel="shortcut icon" href="{{ asset('theme/img/favicon.ico') }}" type="image/x-icon">
	<link href="{{ asset('theme/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('theme/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('theme/css/ruang-admin.css') }}" rel="stylesheet">
	<link href="{{ asset('theme/css/flag-icon.min.css') }}" rel="stylesheet">

</head>

<body class="bg-gradient-login">

	<div class="d-flex p-2 bd-highlight justify-content-center">
		<ul class="navbar-nav ml-auto2">
			<li class="nav-item dropdown mx-3">
				<a class="nav-link dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					@if (App::getLocale() == 'en') <span class="flag-icon flag-icon-gb"></span> @endif
					@if (App::getLocale() == 'ru') <span class="flag-icon flag-icon-ru"></span> @endif
				</a>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<a class="px-3 nav-link nav-link-child @if (App::getLocale() == 'en') nav-link-child-active @endif" href="{{ route('locale', ['locale' => 'en']) }}"><span class="flag-icon flag-icon-gb mr-2"></span> EN</a>
					<a class="px-3 nav-link nav-link-child @if (App::getLocale() == 'ru') nav-link-child-active @endif" href="{{ route('locale', ['locale' => 'ru']) }}"><span class="flag-icon flag-icon-ru mr-2"></span> RU</a>
				</div>
			</li>
		</ul>
	</div>

	@yield('content')

	<script src="{{ asset('theme/vendor/jquery/jquery.min.js') }}"></script>
	<script src="{{ asset('theme/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('theme/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
	<script src="{{ asset('theme/js/ruang-admin.min.js') }}"></script>
	<script src="{{ asset('theme/vendor/chart.js/Chart.min.js') }}"></script>
	<script src="{{ asset('theme/js/demo/chart-area-demo.js') }}"></script>
</body>

</html>