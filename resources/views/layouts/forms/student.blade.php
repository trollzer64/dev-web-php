<h2 class="text-base md:text-4xl font-semibold">{{ $edit ? 'Editar' : 'Cadastro de' }} aluno</h2>
<form class="form-main" action="{{ $edit ? route('editStudent', $edit) : route('saveStudent') }}" method="post"
	accept-charset="UTF-8">
	@csrf
	<div class="form-item">
		<label for="school_id">Escola</label>
		<select name="school_id" autocomplete="off">
			@foreach ($listSchools as $school)
				<option value="{{ $school->school_id }}" {!! old('school_id') ?? ($school_id ?? '') == $school->id ? 'selected' : '' !!}>
					{{ $school->name }}
				</option>
			@endforeach
		</select>
	</div>
	<div class="form-item">
		<label for="name">Nome</label>
		<input type="text" name="name" autocomplete="off" value="{{ old('name') ?? ($name ?? '') }}">
	</div>
	<div class="form-item">
		<label for="registration">Matrícula</label>
		<input type="text" name="registration" autocomplete="off"
			value="{{ old('registration') ?? ($registration ?? '') }}">
	</div>
	<div class="form-item">
		<label for="class">Turma</label>
		<input type="text" name="class" autocomplete="off" value="{{ old('class') ?? ($class ?? '') }}">
	</div>
	<div class="form-item">
		<label for="shift">Turno</label>
		<select name="shift" autocomplete="off">
			<option value="matutino" {!! old('shift') ?? ($shift ?? '') == 'matutino' ? 'selected' : '' !!}>Matutino</option>
			<option value="vespertino" {!! old('shift') ?? ($shift ?? '') == 'vespertino' ? 'selected' : '' !!}>Vespertino</option>
			<option value="noturno" {!! old('shift') ?? ($shift ?? '') == 'noturno' ? 'selected' : '' !!}>Noturno</option>
		</select>
	</div>
	<div class="form-item">
		<label for="balance">Saldo</label>
		<input type="number" name="balance" autocomplete="off" value="{{ old('balance') ?? ($balance ?? '') }}" step="0.50"
			class="opacity-50" readonly>
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
