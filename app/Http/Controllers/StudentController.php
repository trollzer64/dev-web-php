<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Responsible;
use App\Models\School;
use Illuminate\Http\Request;
use App\Models\Student;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Enum;

class StudentController extends Controller
{
	public function index(Request $request)
	{
		$user = Auth::user();
		if ($user) {
			$type = UserController::userType($user->id);
			switch ($type) {
				case 'responsible':
					$responsible = DB::table('responsibles')
						->where('responsibles.user_id', '=', intval($user->id))
						->first();
					$responsibleId = $responsible->id;
					$filterId = null;
					break;
				case 'student':
					$responsibleId = null;
					$filterId = $user->id;
					break;

				default:
					$filterId = null;
					$responsibleId = null;
					break;
			}
		}

		if ($request->has('edit') or $filterId) {
			if ($responsibleId) {
				$filterId = $request->query('edit');
				$students = DB::table('users')
					->where('users.id', '=', intval($filterId))
					->join('students', 'users.id', '=', 'students.user_id')
					->where('students.responsible_id', '=', intval($responsibleId))
					->select(
						'users.*',
						'students.id as student_id',
						'students.school_id',
						'students.responsible_id',
						'students.registration',
						'students.class',
						'students.shift',
						'students.balance'
					)
					->get();
			} else {
				$filterId = $filterId ?: $request->query('edit');
				$students = DB::table('users')
					->where('users.id', '=', intval($filterId))
					->join('students', 'users.id', '=', 'students.user_id')
					->select(
						'users.*',
						'students.id as student_id',
						'students.school_id',
						'students.responsible_id',
						'students.registration',
						'students.class',
						'students.shift',
						'students.balance'
					)
					->get();
			}
		} else {
			if ($responsibleId) {
				$students = DB::table('users')
					->join('students', 'users.id', '=', 'students.user_id')
					->where('students.responsible_id', '=', intval($responsibleId))
					->select(
						'users.*',
						'students.id as student_id',
						'students.school_id',
						'students.responsible_id',
						'students.registration',
						'students.class',
						'students.shift',
						'students.balance'
					)
					->get();
			} else {
				$students = DB::table('users')
					->join('students', 'users.id', '=', 'students.user_id')
					->select(
						'users.*',
						'students.id as student_id',
						'students.school_id',
						'students.responsible_id',
						'students.registration',
						'students.class',
						'students.shift',
						'students.balance'
					)
					->get();
			}
		}

		$schools = DB::table('users')
			->join('schools', 'users.id', '=', 'schools.user_id')
			->select(
				'users.*',
				'schools.id as school_id',
				'schools.address',
			)
			->get();
		if ($students->count() === 0) {
			return view('student', [
				'listStudents' => $students,
				'listSchools' => $schools,
				'student' => null,
			]);
		}
		return view('student', [
			'listStudents' => $students,
			'listSchools' => $schools
		]);
	}
	public function save(Request $request)
	{
		$responsible_user = Auth::user();
		if ($responsible_user) {
			$type = UserController::userType($responsible_user->id);
			switch ($type) {
				case 'responsible':
					try {
						DB::beginTransaction();
						$responsible = DB::table('responsibles')
							->where('user_id', '=', $responsible_user->id)
							->first();

						$newUser = UserController::save($request);
						$newUser->save();

						$validatedData = $request->validate([
							'registration' => ['required', 'string'],
							'class' => ['required', 'string'],
							'shift' => ['required', 'string', 'in:matutino,vespertino,noturno'],
							'balance' => ['required', 'numeric'],
							'school_id' => ['required', 'numeric', 'exists:schools,id'],
						]);

						$newStudent = new Student;
						$newStudent->registration = $validatedData['registration'];
						$newStudent->class = $validatedData['class'];
						$newStudent->shift = $validatedData['shift'];
						$newStudent->balance = $validatedData['balance'];
						$newStudent->school_id = $validatedData['school_id'];

						$newStudent->user_id = $newUser->id;
						$newStudent->responsible_id = $responsible->id;

						$newStudent->save();

						DB::commit();
					} catch (Exception $e) {
						DB::rollBack();
						throw $e;
					}

					return redirect('/student');
				default:
					return back()->withErrors([
						'access' => 'N??o autorizado',
					]);
			}
		}
	}
	public function edit($id, Request $request)
	{
		$responsible_user = Auth::user();
		$type = UserController::userType($responsible_user->id);
		switch ($type) {
			case 'admin':
			case 'school':
			case 'responsible':
				$student = Student::find($id);
				if ($student) {
					$user = UserController::edit($student->user_id, $request);
					if ($user) {
						try {
							DB::beginTransaction();
							$user->save();

							$validatedData = $request->validate([
								'registration' => ['required', 'string'],
								'class' => ['required', 'string'],
								'shift' => ['required', 'string', 'in:matutino,vespertino,noturno'],
								'balance' => ['required', 'numeric'],
							]);
							$student->registration = $validatedData['registration'];
							$student->class = $validatedData['class'];
							$student->shift = $validatedData['shift'];
							$student->balance = $validatedData['balance'];

							$student->save();
							DB::commit();
						} catch (Exception $e) {
							DB::rollBack();
							throw $e;
						}
						return redirect('/student');
					}
				}
				return back()->withErrors([
					'found' => 'N??o encontrado',
				]);

			default:
				return back()->withErrors([
					'access' => 'N??o autorizado',
				]);
		}
	}
	public function delete($id, Request $request)
	{
		$responsible_user = Auth::user();
		$type = UserController::userType($responsible_user->id);
		switch ($type) {
			case 'admin':
			case 'school':
			case 'responsible':
				$student = Student::find($id);
				if ($student) {
					try {
						DB::beginTransaction();
						UserController::delete($student->user_id, $request);
						DB::commit();
					} catch (Exception $e) {
						DB::rollBack();
						throw $e;
					}
					return redirect('/student');
				}
				return back()->withErrors([
					'found' => 'N??o encontrado',
				]);

			default:
				return back()->withErrors([
					'access' => 'N??o autorizado',
				]);
		}
	}
	public function deposit($id, Request $request){
		$responsible_user = Auth::user();
		$type = UserController::userType($responsible_user->id);
		switch ($type) {
			case 'admin':
			case 'school':
			case 'responsible':
				$student = Student::find($id);
				if ($student) {
					try {
						DB::beginTransaction();

						$validatedData = $request->validate([
							'deposit' => ['required', 'numeric'],
						]);
						$student->balance += $validatedData['deposit'];

						$student->save();
						DB::commit();
					} catch (Exception $e) {
						DB::rollBack();
						throw $e;
					}
					return redirect('/student');
				}
				return back()->withErrors([
					'found' => 'N??o encontrado',
				]);

			default:
				return back()->withErrors([
					'access' => 'N??o autorizado',
				]);
		}
	}
}
