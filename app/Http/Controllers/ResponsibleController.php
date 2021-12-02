<?php

namespace App\Http\Controllers;

use App\Models\Responsible;
use App\Models\School;
use Exception;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ResponsibleController extends Controller
{
	public function index(Request $request)
	{
		$user = Auth::user();
		if ($user) {
			$type = UserController::userType($user->id);
			switch ($type) {
				case 'responsible':
					$filterId = $user->id;
					break;

				default:
					$filterId = null;
					break;
			}
		}
		if ($request->has('edit') or $filterId) {
			$filterId = $filterId ?: $request->query('edit');
			$responsibles = DB::table('users')
				->where('users.id', '=', intval($filterId))
				->join('responsibles', 'users.id', '=', 'responsibles.user_id')
				->select(
					'users.*',
					'responsibles.id as responsible_id',
					'responsibles.cpf',
				)
				->get();
		} else {
			$responsibles = DB::table('users')
				->join('responsibles', 'users.id', '=', 'responsibles.user_id')
				->select(
					'users.*',
					'responsibles.id as responsible_id',
					'responsibles.cpf',
				)
				->get();
		}

		return view('responsible', [
			'listResponsibles' => $responsibles,
		]);
	}
	public function save(Request $request)
	{
		$school_user = Auth::user();
		if ($school_user) {
			$type = UserController::userType($school_user->id);
			switch ($type) {
				case 'school':
					try {
						DB::beginTransaction();
						$school = DB::table('schools')
							->where('user_id', '=', $school_user->id)
							->first();

						$newUser = UserController::save($request);
						$newUser->save();

						$validatedData = $request->validate([
							'cpf' => ['required', 'cpf', 'unique:responsibles,cpf'],
						]);

						$newResponsible = new Responsible;
						$newResponsible->cpf = $validatedData['cpf'];

						$newResponsible->user_id = $newUser->id;

						$newResponsible->save();

						DB::commit();
					} catch (Exception $e) {
						DB::rollBack();
						throw $e;
					}

					return redirect('/responsible');
				default:
					return back()->withErrors([
						'access' => 'Não autorizado',
					]);
			}
		}
	}
	public function edit($id, Request $request)
	{
		$responsible_user = Auth::user();
		$type = UserController::userType($responsible_user->id);
		switch ($type) {
			case 'responsible':
				$responsible = Responsible::find($responsible_user->id);
				// garantir que somente possa editar o aluno do responsável atual
				$responsible = Responsible::find($id);
				if ($responsible) {
					$user = UserController::edit($responsible->user_id, $request);
					if ($user) {
						try {
							DB::beginTransaction();
							$user->save();

							$validatedData = $request->validate([
								'cpf' => ['required', 'cpf', Rule::unique('responsibles')->ignore($id)],
							]);

							$responsible->cpf = $validatedData['cpf'];

							$responsible->save();
							DB::commit();
						} catch (Exception $e) {
							DB::rollBack();
							throw $e;
						}
						return redirect('/responsible');
					}
				}
				return back()->withErrors([
					'found' => 'Não encontrado',
				]);

			default:
				return back()->withErrors([
					'access' => 'Não autorizado',
				]);
		}
	}
	public function delete($id, Request $request)
	{
		$school_user = Auth::user();
		$type = UserController::userType($school_user->id);
		switch ($type) {
			case 'school':
				$school = School::find($school_user->id);
				$responsible = Responsible::find($id);
				if ($responsible) {
					try {
						DB::beginTransaction();
						UserController::delete($responsible->user_id, $request);
						DB::commit();
					} catch (Exception $e) {
						DB::rollBack();
						throw $e;
					}
					return redirect('/responsible');
				}
				return back()->withErrors([
					'found' => 'Não encontrado',
				]);

			default:
				return back()->withErrors([
					'access' => 'Não autorizado',
				]);
		}
	}
}
