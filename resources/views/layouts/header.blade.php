<div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
	<div class="text-sm lg:flex-grow">
		<a href="/home" class="block mt-4 lg:inline-block lg:mt-0 text-green-200 hover:text-white mr-4">
			Home
		</a>
		@if (session()->get('type') === 'admin')
			<a href="/admin" class="block mt-4 lg:inline-block lg:mt-0 text-green-200 hover:text-white mr-4">
				Admnistradores
			</a>
		@endif
		@if (in_array(session()->get('type'), ['responsible', 'school', 'admin'], true))
			<a href="/responsible" class="block mt-4 lg:inline-block lg:mt-0 text-green-200 hover:text-white mr-4">
				{{ session()->get('type') === 'responsible' ? 'Responsável' : 'Responsáveis' }}
			</a>
			<a href="/student" class="block mt-4 lg:inline-block lg:mt-0 text-green-200 hover:text-white mr-4">
				Alunos
			</a>
		@endif
		@if (in_array(session()->get('type'), ['admin', 'school'], true))
			<a href="/school" class="block mt-4 lg:inline-block lg:mt-0 text-green-200 hover:text-white mr-4">
				{{ session()->get('type') === 'school' ? 'Escola' : 'Escolas' }}
			</a>
		@endif
	</div>
	<div>
		<a href="/logout"
			class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal-500 hover:bg-white mt-4 lg:mt-0">
			Logout
		</a>
	</div>
</div>
