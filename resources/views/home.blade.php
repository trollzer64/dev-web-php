@extends('layouts.app')

@section('title', 'Gerenciamento de Estudante')
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
		@include('layouts.header')
	</nav>
@endsection

@section('content')
	<div class="">
		<section>
			<h1 class="text-base md:text-4xl font-semibold">Área do Usuário</h1>
			<p>Bem vindo {{ $user->name }}</p>
		</section>
	</div>
@endsection
