<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
	public function index(Request $request)
	{
		if ($request->has('edit')) {
			$filterId = $request->query('edit');
			$admins = DB::table('users')
				->where('users.id', '=', intval($filterId))
				->join('admins', 'users.id', '=', 'admins.user_id')
				->select('users.*', 'admins.id as admin_id')
				->get();
		} else {
			$admins = DB::table('users')
				->join('admins', 'users.id', '=', 'admins.user_id')
				->select('users.*', 'admins.id as admin_id')
				->get();
		}
		return view('admin', [
			'listAdmins' => $admins
		]);
	}

	public function save(Request $request)
	{
		$admin_user = Auth::user();
		$type = UserController::userType($admin_user->id);
		switch ($type) {
			case 'admin':
				try {
					DB::beginTransaction();
					$newUser = UserController::save($request);
					$newUser->save();

					$newAdmin = new Admin;
					$newAdmin->user_id = $newUser->getKey();
					$newAdmin->save();
					DB::commit();
				} catch (Exception $e) {
					DB::rollBack();
					throw $e;
				}
				return redirect('/admin');
			default:
				return back()->withErrors([
					'access' => 'Não autorizado',
				]);
		}
	}

	public function edit($id, Request $request)
	{
		$admin_user = Auth::user();
		$type = UserController::userType($admin_user->id);
		switch ($type) {
			case 'admin':
				$admin = Admin::find($id);
				if ($admin) {
					$user = UserController::edit($admin->user_id, $request);
					if ($user) {
						try {
							DB::beginTransaction();
							$user->save();

							$admin->save();
							DB::commit();
						} catch (Exception $e) {
							DB::rollBack();
							throw $e;
						}
						return redirect('/admin');
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
		$admin_user = Auth::user();
		$type = UserController::userType($admin_user->id);
		switch ($type) {
			case 'admin':
				$admin = Admin::find(intval($id));
				try {
					DB::beginTransaction();

					UserController::delete($admin->user_id, $request);

					DB::commit();
				} catch (Exception $e) {
					DB::rollBack();
					throw $e;
				}
				return redirect('/admin');
			default:
				return back()->withErrors([
					'access' => 'Não autorizado',
				]);
		}
	}
}
