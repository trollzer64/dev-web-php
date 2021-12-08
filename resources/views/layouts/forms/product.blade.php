<h2 class="text-base md:text-4xl font-semibold">{{ $edit ? 'Editar' : 'Cadastro de' }} produto</h2>
<form class="form-main" action="{{ $edit ? route('editProduct', $edit) : route('saveProduct') }}" method="post"
	accept-charset="UTF-8">
	@csrf

	<div class="form-item">
		<label for="code">Código</label>
		<input type="text" name="code" autocomplete="off" value="{{ old('code') ?? ($code ?? '') }}">
	</div>
	<div class="form-item">
		<label for="name">Nome</label>
		<input type="text" name="name" autocomplete="off" value="{{ old('name') ?? ($name ?? '') }}">
	</div>
	<div class="form-item">
		<label for="photo">Foto</label>
		<input type="text" name="photo" autocomplete="off" value="{{ old('photo') ?? ($photo ?? '') }}">
	</div>
	<div class="form-item">
		<label for="price">Preço</label>
		<input type="number" name="price" autocomplete="off" value="{{ old('price') ?? ($price ?? '') }}" step="0.50">
	</div>
	<div class="form-item">
		<label for="type">Tipo</label>
		<select name="type" autocomplete="off">
			<option value="food" {!! old('type') ?? ($type ?? '') == 'food' ? 'selected' : '' !!}>Comida</option>
			<option value="drink" {!! old('type') ?? ($type ?? '') == 'drink' ? 'selected' : '' !!}>Bebida</option>
		</select>
	</div>

	<div class="form-item">
		<label for="ingredients">Ingredientes</label>
		<input type="text" name="ingredients" autocomplete="off" value="{{ old('ingredients') ?? ($ingredients ?? '') }}">
	</div>
	<div class="form-item">
		<label for="provider">Fornecedor</label>
		<input type="text" name="provider" autocomplete="off" value="{{ old('provider') ?? ($provider ?? '') }}">
	</div>

	@if (session('errors'))
		<span class="flex-grow-0 text-red-500">{{ session('errors')->first() }}</span>
	@endif
	<div class="flex">
		<button class="btn-blue" type="submit">Salvar</button>
		@if ($edit)
			<a href="{{ URL::previous() }}" class="btn-red">Cancelar</a>
		@endif
	</div>
</form>
