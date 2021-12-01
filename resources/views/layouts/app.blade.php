<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<title>CantiSystem - @yield('title', 'Cantina eletrônica')</title>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<!-- Styles -->
	<link rel="stylesheet" href="{{ secure_asset('https://unpkg.com/normalize.css@8.0.1/normalize.css') }}">
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="flex flex-col h-screen">
	<header class="@yield('header-class', 'fixed w-screen')">
		@section('top')
		@show
	</header>

	<div class="flex-1 overflow-auto">
		@yield('content')
	</div>
</body>

</html>
