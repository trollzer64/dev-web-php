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
		<div class="block lg:hidden">
			<button
				class="flex items-center px-3 py-2 border rounded text-green-200 border-green-400 hover:text-white hover:border-white">
				<svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
					<title>Menu</title>
					<path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
				</svg>
			</button>
		</div>
		@include('layouts.header')
	</nav>
@endsection

@section('content')
	<div class="p-2">
		<h1 class="text-base md:text-4xl font-semibold">Área do Aluno</h1>
		<section id="list">
			<h2 class="text-base md:text-2xl">Alunos cadastrados</h2>
			<div class="list-container">
				@foreach ($listStudents as $student)
					<div class="flex flex-col items-center">
						<form action="{{ route('deleteStudent', $student->student_id) }}" method="post">
							@csrf
							<button class="btn-red" type="submit" {!! Auth::user()->id === $student->id ? 'disabled' : '' !!}>
								Deletar
							</button>
						</form>
						<a href="{{ Request::url() . '?edit=' . $student->id . '#form' }} " class="btn-blue">
							Editar
						</a>
						<form class="deposit" action="{{ route('depositStudent', $student->student_id) }}" method="POST">
							@csrf
							<input name="deposit" type="number" hidden value="0.00">
							<button class="btn-red" type="submit" {!! Auth::user()->id === $student->id ? 'disabled' : '' !!}>
								Depositar
							</button>
						</form>
					</div>
					<div class="item-container">
						<span>Nome: {{ $student->name }}</span>
						<span>Matrícula: {{ $student->registration }}</span>
						<span>Turma: {{ $student->class }}</span>
						<span>Turno: {{ $student->shift }}</span>
						<span>Saldo: R$ {{ number_format($student->balance, 2, ',', ' ') }}</span>
						<span>Telefone: {{ $student->phone }}</span>
						<span>Email: {{ $student->email }}</span>
						<span>Login: {{ $student->login }}</span>
						<span>Criado:
							<time datetime="{{ $student->created_at }}">{{ $student->created_at }}</time>
						</span>
						<span>Atualizado:
							<time datetime="{{ $student->updated_at }}">{{ $student->updated_at }}</time>
						</span>
					</div>

				@endforeach
			</div>
		</section>

		<section id="form" class="flex flex-col items-center">
			@includeWhen(!Request::get('edit') and session()->get('type') !== 'school' and session()->get('type') !== 'student',
			'layouts.forms.student', [
			'edit'=> false,
			'balance'=>"0,00",
			])
			@if (Request::get('edit') == ($student ? $student->id : -1))
				@includeWhen(Request::get('edit') == ($student ? $student->id : -1),
				'layouts.forms.student',
				[
				'edit'=> $student->student_id,
				'school_id'=> $student->school_id,
				'name'=> $student->name,
				'registration'=> $student->registration,
				'class'=> $student->class,
				'shift'=> $student->shift,
				'balance'=> $student->balance,
				'phone'=> $student->phone,
				'email'=> $student->email,
				'login'=> $student->login,
				'password'=> $student->password,
				])
			@endif
		</section>
	</div>
@endsection

<script>
 window.onload = function() {
  const forms = document.querySelectorAll("form.deposit");
  forms.forEach((form) => {
   const input = form.children.item(1);
   form.onsubmit = function(event) {
    /* do what you want with the form */
    const prompted = prompt("Entre o valor que deseja depositar", "0.00");
    input.value = prompted;
    return true;
   };
  });

 };
</script>
