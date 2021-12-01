@extends('layouts.app')

@section('title', 'Admin')
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
		<h1 class="text-base md:text-4xl font-semibold">Área da admnistração</h1>
		<section id="list">
			<h2 class="text-base md:text-2xl">Admnistradores cadastrados</h2>
			<div class="list-container">
				@foreach ($listAdmins as $admin)
					<div class="flex flex-col">
						<form action="{{ route('deleteAdmin', $admin->admin_id) }}" method="post">
							@csrf
							<button class="btn-red" type="submit" {!! Auth::user()->id === $admin->id ? 'disabled' : '' !!}>
								Deletar
							</button>
						</form>
						<a href="{{ Request::url() . '?edit=' . $admin->id . "#form" }} " class="btn-blue">
							Editar
						</a>
					</div>

					<div class="item-container">
						<span>Nome: {{ $admin->name }}</span>
						<span>Telefone: {{ $admin->phone }}</span>
						<span>Email: {{ $admin->email }}</span>
						<span>Login: {{ $admin->login }}</span>
						<span>Criado:
							<time datetime="{{ $admin->created_at }}">{{ $admin->created_at }}</time>
						</span>
						<span>Atualizado:
							<time datetime="{{ $admin->updated_at }}">{{ $admin->updated_at }}</time>
						</span>
					</div>

				@endforeach
			</div>
		</section>

		<section id="form" class="flex flex-col items-center">
			@includeWhen(!Request::get('edit'), 'layouts.forms.admin', [
			'edit'=> false
			])
			@includeWhen(Request::get('edit') == $admin->id, 'layouts.forms.admin',
			[
			'edit'=> $admin->admin_id,
			'name'=> $admin->name,
			'phone'=> $admin->phone,
			'email'=> $admin->email,
			'login'=> $admin->login,
			'password'=> $admin->password,
			])
		</section>
	</div>
@endsection
