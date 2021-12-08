@extends('layouts.app')

@section('title', 'Produtos')
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
		<h1 class="text-base md:text-4xl font-semibold">Área dos produtos</h1>
		<section id="list">
			<h2 class="text-base md:text-2xl">Produtos cadastrados</h2>
			<div class="list-container">
				@foreach ($listProducts as $product)
					<div class="flex flex-col items-center">
						<form action="{{ route('deleteProduct', $product->id) }}" method="post">
							@csrf
							<button class="btn-red" type="submit" {!! session()->get('type') === 'student' ? 'disabled' : '' !!}>
								Deletar
							</button>
						</form>
						<a href="{{ Request::url() . '?edit=' . $product->id . '#form' }}"
							class="btn-blue
							{!! session()->get('type') === 'student' ? 'disabled' : '' !!}">
							Editar
						</a>
						@if (session()->get('type') === 'student')
							<form action="{{ route('buyProduct', $product->id) }}" method="post">
								@csrf
								<button class="btn-red" type="submit">
									Comprar
								</button>
							</form>
						@endif
					</div>
					<div class="item-container">
						<img class="fit-picture" src="{{ $product->photo }}" alt="product">
						<span>Código: {{ $product->code }}</span>
						<span>Nome: {{ $product->name }}</span>
						<span>Preço: R$ {{ number_format($product->price, 2, ',', ' ') }}</span>
						{{-- <span>Tipo: {{ $product->type }}</span> --}}
						@if ($product->type === 'food')
							<span>Ingredientes: {{ $product->ingredients }}</span>
						@else
							<span>Fornecedor: {{ $product->provider }}</span>
						@endif
						<span>Criado:
							<time datetime="{{ $product->created_at }}">{{ $product->created_at }}</time>
						</span>
						<span>Atualizado:
							<time datetime="{{ $product->updated_at }}">{{ $product->updated_at }}</time>
						</span>
					</div>

				@endforeach
			</div>
		</section>

		<section id="form" class="flex flex-col items-center">
			@includeWhen(!Request::get('edit') and in_array(session()->get('type'), ['school', 'admin'], true),
			'layouts.forms.product', [
			'edit'=> false,
			'price'=>"0,00",
			])
			@if (Request::get('edit') == ($product ? $product->id : -1))
				@includeWhen(Request::get('edit') == ($product ? $product->id : -1),
				'layouts.forms.product',
				[
				'edit'=> $product->id,
				'code'=> $product->code,
				'name'=> $product->name,
				'photo'=> $product->photo,
				'price'=> $product->price,
				'type'=> $product->type,
				'ingredients'=> $product->ingredients,
				'provider'=> $product->provider,
				])
			@endif
		</section>
	</div>
@endsection
