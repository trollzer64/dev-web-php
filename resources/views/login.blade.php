@extends('layouts.app')

@section('title', 'Login')
@section('header-class', 'w-screen')

@section('top')
	@parent

	<nav class="flex items-center justify-between flex-wrap bg-green-500 p-6">
		<div class="flex items-center flex-shrink-0 text-white mr-6">
			<img class="m-2" src="{{ asset('assets/logo.png') }}" alt="logo">
			<span class="font-semibold text-xl tracking-tight">
				<a href="/">CantiSystem</a>
			</span>
		</div>
	</nav>
@endsection

@section('content')
	<div class="flex flex-col items-center">
		<h1 class="text-base md:text-4xl font-semibold">Login</h1>

		<form class="form-main" action="{{ route('login') }}" method="post" accept-charset="UTF-8">
			@csrf
			<div class="form-item">
				<label for="login">Login</label>
				<input type="text" name="login" autocomplete="off">
			</div>
			<div class="form-item">
				<label for="password">Senha</label>
				<input type="text" name="password" autocomplete="off">
			</div>

			<p></p>
			@if (session('errors'))
				<span class="text-red-500">{{ session('errors')->first() }}</span>
			@endif
			<button class="btn-blue" type="submit">Login</button>
		</form>
	</div>
@endsection
