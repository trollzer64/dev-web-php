<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use App\Models\Responsible;
use App\Models\School;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Rules\Password;
use App\Rules\PhoneNumber;
use \Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
	public function authenticate(Request $request)
	{
		$credentials = $request->validate([
			'login' => ['required'],
			'password' => ['required'],
		]);

		if (Auth::attempt($credentials)) {
			$request->session()->regenerate();
			$request->session()->put('type', $this->userType(Auth::user()->id));

			return redirect()->intended('home');
		}

		return back()->withErrors([
			'login' => 'Usuário/Email ou senha incorreto!',
		]);
	}
	public function logout(Request $request)
	{
		Auth::logout();

		$request->session()->invalidate();
		$request->session()->regenerateToken();

		return redirect('/');
	}

	public static function userType($id)
	{
		$admin = Admin::where('user_id', $id)->first();
		if ($admin) return 'admin';
		$school = School::where('user_id', $id)->first();
		if ($school) return 'school';
		$responsible = Responsible::where('user_id', $id)->first();
		if ($responsible) return 'responsible';
		$student = Student::where('user_id', $id)->first();
		if ($student) return 'student';
		return null;
	}

	public function home()
	{
		$user = Auth::user();
		$id = $user->id;
		$type = $this->userType($id);
		switch ($type) {
			case 'admin':
				return view('home', [
					'admin' => Admin::find($id),
					'user' => $user,
				]);
			case 'school':
				return view('home', [
					'school' => School::find($id),
					'user' => $user,
				]);
			case 'responsible':
				return view('home', [
					'responsible' => Responsible::find($id),
					'user' => $user,
				]);
			case 'student':
				return view('home', [
					'student' => Student::find($id),
					'user' => $user,
				]);

			default:
				return redirect('/login')->withErrors([
					'login' => 'Tipo de usuário incorreto. Contate o admnistrador',
				]);
		}
	}

	public static function save(Request $request)
	{
		$validatedData = $request->validate([
			'email' => ['required', 'string', 'email', 'unique:App\Models\User'],
			'login' => ['required', 'string', 'unique:App\Models\User'],
			'password' => ['required', 'string', new Password, 'confirmed'],
			'name' => ['required', 'string'],
			'phone' => ['required', new PhoneNumber],
		]);

		$newUser = new User();
		$newUser->email = $validatedData['email'];
		$newUser->login = $validatedData['login'];
		$newUser->password = Hash::make($validatedData['password']);
		$newUser->name = $validatedData['name'];
		$newUser->phone = $validatedData['phone'];

		// $newUser->save();
		return $newUser;
	}

	public static function edit($id, Request $request)
	{
		$validatedData = $request->validate([
			'email' => ['required', 'string', 'email', Rule::unique('users')->ignore($id)],
			'login' => ['required', 'string', Rule::unique('users')->ignore($id)],
			'password' => ['required', 'string', new Password, 'confirmed'],
			'name' => ['required', 'string'],
			'phone' => ['required', new PhoneNumber],
		]);

		$user = User::find($id);
		if ($user) {
			$user->email = $validatedData['email'];
			$user->login = $validatedData['login'];
			$user->password = Hash::make($validatedData['password']);
			$user->name = $validatedData['name'];
			$user->phone = $validatedData['phone'];

			// $user->save();
			return $user;
		}

		return null;
	}
	public static function delete($id, Request $request)
	{
		User::destroy($id);
	}
}
