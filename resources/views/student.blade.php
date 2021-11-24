@extends('layouts.app')

@section('title', 'Gerenciamento de Estudante')

@section('top')
	@parent

	<p>This is appended to the master sidebar.</p>
@endsection

@section('content')
	<div class="">
		<h1>Área do Aluno</h1>
		<h2>Alunos cadastrados</h2>
		@foreach ($listStudents as $student)
			<p>Nome: {{ $student->name }}</p>
			{{-- <form action="{{ route('editStudent', $student->id) }}" method="post" accept-charset="UTF-8">
			{{ csrf_field() }}

			<label for="name">Nome: {{ $student->name }}</label>
			<input type="text" name="name" id="student-{{ $student->id }}">
			<button type="submit">Salvar Alteração</button>
		</form> --}}
		@endforeach

		<h2>Cadastro de Aluno</h2>
		<form class="" action="{{ route('saveStudent') }}" method="post" accept-charset="UTF-8">
			{{ csrf_field() }}
			<div class="">
				<label for="name">Nome</label>
				<input type="text" name="name">
			</div>
			<button type="submit">Cadastrar</button>
		</form>
	</div>
@endsection
