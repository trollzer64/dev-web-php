<h2 class="text-base md:text-4xl font-semibold">{{ $edit ? 'Editar' : 'Cadastro de' }} responsável</h2>
<form class="form-main" action="{{ $edit ? route('editResponsible', $edit) : route('saveResponsible') }}"
	method="post" accept-charset="UTF-8">
	@csrf

	<div class="form-item">
		<label for="name">Nome</label>
		<input type="text" name="name" autocomplete="off" value="{{ old('name') ?? ($name ?? '') }}">
	</div>
	<div class="form-item">
		<label for="cpf">CPF</label>
		<input type="text" name="cpf" autocomplete="off" value="{{ old('cpf') ?? ($cpf ?? '') }}">
	</div>
	<div class="form-item">
		<label for="phone">Telefone</label>
		<input type="tel" name="phone" autocomplete="off" value="{{ old('phone') ?? ($phone ?? '') }}">
	</div>
	<div class="form-item">
		<label for="email">Email</label>
		<input type="email" name="email" autocomplete="off" value="{{ old('email') ?? ($email ?? '') }}">
	</div>
	<div class="form-item">
		<label for="login">Login</label>
		<input type="text" name="login" autocomplete="off" value="{{ old('login') ?? ($login ?? '') }}">
	</div>
	<div class="form-item">
		<label for="password">Senha</label>
		<input type="text" name="password" autocomplete="off">
	</div>
	<div class="form-item">
		<label for="password_confirmation">Cofirmar Senha</label>
		<input type="text" name="password_confirmation" autocomplete="off">
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
