<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student as ModelsStudent;

class StudentController extends Controller
{
	public function index()
	{
		// Como fazer uma query condicional
		// return view('welcome', ['listStudents' => ModelsStudent::where('name', 'Nome a procurar')->get()]);
		return view('student', ['listStudents' => ModelsStudent::all()]);
	}
	public function save(Request $request)
	{
		$newStudent = new ModelsStudent;
		$newStudent->name = $request->name;

		$newStudent->save();

		return redirect('/student');
	}
	public function edit($id, Request $request)
	{
		$student = ModelsStudent::find($id);
		$student->name = $request->name;

		$student->save();

		return redirect('/student');
	}
}
