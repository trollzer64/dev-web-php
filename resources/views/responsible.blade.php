@extends('layouts.app')

@section('title', 'Responsável')
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
	<div class="p-2">
		<h1 class="text-base md:text-4xl font-semibold">Área dos responsáveis</h1>
		<section id="list">
			<h2 class="text-base md:text-2xl">Responsáveis cadastrados</h2>
			<div class="list-container">
				@foreach ($listResponsibles as $responsible)
					<div class="flex flex-col">
						<form action="{{ route('deleteResponsible', $responsible->responsible_id) }}" method="post">
							@csrf
							<button class="btn-red" type="submit" {!! Auth::user()->id === $responsible->id ? 'disabled' : '' !!}>
								Deletar
							</button>
						</form>
						@if (session()->get('type') !== 'school')
							<a href="{{ Request::url() . '?edit=' . $responsible->id . '#form' }} " class="btn-blue">
								Editar
							</a>
						@endif
					</div>

					<div class="item-container">
						<span>Nome: {{ $responsible->name }}</span>
						<span>CPF: {{ $responsible->cpf }}</span>
						<span>Telefone: {{ $responsible->phone }}</span>
						<span>Email: {{ $responsible->email }}</span>
						<span>Login: {{ $responsible->login }}</span>
						<span>Criado:
							<time datetime="{{ $responsible->created_at }}">{{ $responsible->created_at }}</time>
						</span>
						<span>Atualizado:
							<time datetime="{{ $responsible->updated_at }}">{{ $responsible->updated_at }}</time>
						</span>
					</div>

				@endforeach
			</div>
		</section>

		<section id="form" class="flex flex-col items-center">
			@includeWhen(
			!Request::get('edit') and session()->get('type') !== 'responsible',
			'layouts.forms.responsible',
			[
			'edit'=> false
			])
			@includeWhen(Request::get('edit') == $responsible->id, 'layouts.forms.responsible',
			[
			'edit'=> $responsible->responsible_id,
			'name'=> $responsible->name,
			'cpf'=> $responsible->cpf,
			'phone'=> $responsible->phone,
			'email'=> $responsible->email,
			'login'=> $responsible->login,
			'password'=> $responsible->password,
			])
		</section>
	</div>
@endsection
