@extends('layouts.app')

@section('title', 'Bem vindo')

@section('top')
	@parent

	<nav class="flex items-center justify-between flex-wrap bg-green-500 p-6">
		<div class="flex items-center flex-shrink-0 text-white mr-6">
			<img class="m-2" src="{{ asset('assets/logo.png') }}" alt="logo">
			<span class="font-semibold text-xl tracking-tight">
				<a href="/">CantiSystem</a>
			</span>
		</div>
		<div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
			<div class="text-sm lg:flex-grow">
				<a href="#home" class="block mt-4 lg:inline-block lg:mt-0 text-green-200 hover:text-white mr-4">
					Home
				</a>
				<a href="#vantages" class="block mt-4 lg:inline-block lg:mt-0 text-green-200 hover:text-white mr-4">
					Vantagens
				</a>
				<a href="#target" class="block mt-4 lg:inline-block lg:mt-0 text-green-200 hover:text-white">
					Objetivo
				</a>
			</div>
			<div>
				<a href="/login"
					class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal-500 hover:bg-white mt-4 lg:mt-0">
					Login
				</a>
			</div>
		</div>
	</nav>
@endsection

@section('content')
	<main>

		<section id="home"
			class="h-screen bg-lunch bg-cover bg-gray-500 bg-blend-multiply
		flex flex-col justify-center items-start
		px-40
		overflow-hidden">
			<h1 class="text-base md:text-4xl font-semibold text-white">
				Bem vindo ao <span class="text-yellow-500">CantiSystem</span>
			</h1>
			<h2 class="text-base md:text-2xl text-white">O melhor sistema para administrar e
				cuidar da sua cantina escolar</h2>
		</section>
		<section id="vantages"
			class="h-screen bg-control-food bg-cover bg-gray-500 bg-blend-multiply
		flex flex-col justify-center items-start
		px-40
		overflow-hidden">
			<h1 class="text-base md:text-4xl font-semibold text-yellow-500">
				Vantagens do CantiSystem
			</h1>
			<div class="flex flex-col">
				<div class="text-white">
					<h2 class="text-base md:text-2xl text-white">
						Gerenciamento da alimentação</h2>
					<p class="text-base md:text-lg italic">
						O responsável possui uma visão do que o aluno está consumindo por dia,
						além de poder controlar os hábitos alimentares,
						bloqueando o consumo de produtos (p.e. refrigerante).</p>
				</div>
				<div class="text-white">
					<h2 class="text-base md:text-2xl">
						Gerenciamento de gastos dos seus filhos</h2>
					<p class="text-base md:text-lg italic">
						Tenha controle diário do consumo do aluno. É possível realizar
						depósitos a qualquer momento e consultar o seu saldo. </p>
				</div>
			</div>
		</section>
		<section id="target"
			class="h-screen bg-manager-canteen bg-cover bg-gray-500 bg-blend-multiply
		flex flex-col justify-center items-start
		px-40
		overflow-hidden">
			<h1 class="text-base md:text-4xl font-semibold text-yellow-500">
				Objetivo do CantiSystem
			</h1>
			<div class="flex flex-col">
				<div class="text-white">
					<h2 class="text-base md:text-2xl text-white">
						Gerenciar Estoque</h2>
					<p class="text-base md:text-lg italic">
						Tenha controle do estoque da cantina da sua escola e deixe em dia todos os seus produtos.</p>
				</div>
				<div class="text-white">
					<h2 class="text-base md:text-2xl">
						Controle de Gastos</h2>
					<p class="text-base md:text-lg italic">
						Ajudar os responsáveis a realizar o controle de gastos dos seus filhos.</p>
				</div>
			</div>
		</section>
		{{-- 
		<footer id="footer">
			<div class="container">
				<div class="copyright">
					&copy; Copyright <strong><span>CantiSystem</span></strong>. All Rights Reserved
				</div>
			</div>
		</footer> --}}
	</main>
@endsection
