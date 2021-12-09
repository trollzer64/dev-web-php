<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Product;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
	public function index(Request $request)
	{
		if ($request->has('edit')) {
			$filterId = $request->query('edit');
			$products = DB::table('products')
				->where('products.id', '=', intval($filterId))
				->select()
				->get();
		} else {
			$products = DB::table('products')
				->select()
				->get();
		}
		return view('product', [
			'listProducts' => $products
		]);
	}
	public function save(Request $request)
	{
		$school_user = Auth::user();
		$type = UserController::userType($school_user->id);
		switch ($type) {
			case 'admin':
			case 'school':
				try {
					DB::beginTransaction();

					$validatedData = $request->validate([
						'code' => ['required', 'string', 'unique:products,code'],
						'name' => ['required', 'string'],
						'photo' => ['required', 'file'],
						'price' => ['required', 'numeric'],
						'type' => ['required', 'string', 'in:food,drink'],
						'ingredients' => ['nullable', 'string'],
						'provider' => ['nullable', 'string'],
					]);

					$path = $request->file('photo')->store('photos');

					$newProduct = new Product;
					$newProduct->code = $validatedData['code'];
					$newProduct->name = $validatedData['name'];
					$newProduct->photo = 'storage/' . $path;
					$newProduct->price = $validatedData['price'];
					$newProduct->type = $validatedData['type'];
					$newProduct->ingredients = $validatedData['ingredients'];
					$newProduct->provider = $validatedData['provider'];

					$newProduct->save();

					DB::commit();
				} catch (Exception $e) {
					DB::rollBack();
					throw $e;
				}
				return redirect('/product');
			default:
				return back()->withErrors([
					'access' => 'Não autorizado',
				]);
		}
	}
	public function edit($id, Request $request)
	{
		$school_user = Auth::user();
		$type = UserController::userType($school_user->id);
		switch ($type) {
			case 'admin':
			case 'school':
				$product = Product::find($id);
				if ($product) {
					try {
						DB::beginTransaction();

						$validatedData = $request->validate([
							'code' => ['required', 'string', Rule::unique('products')->ignore($id)],
							'name' => ['required', 'string'],
							'photo' => ['required', 'file'],
							'price' => ['required', 'numeric'],
							'type' => ['required', 'string', 'in:food,drink'],
							'ingredients' => ['nullable', 'string'],
							'provider' => ['nullable', 'string'],
						]);

						$path = $request->file('photo')->store('photos');

						$product->code = $validatedData['code'];
						$product->name = $validatedData['name'];
						$product->photo = 'storage/' . $path;
						$product->price = $validatedData['price'];
						$product->type = $validatedData['type'];
						$product->ingredients = $validatedData['ingredients'];
						$product->provider = $validatedData['provider'];

						$product->save();
						DB::commit();
					} catch (Exception $e) {
						DB::rollBack();
						throw $e;
					}
					return redirect('/product');
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
			case 'admin':
			case 'school':
				$product = Product::find($id);
				if ($product) {
					try {
						DB::beginTransaction();

						Product::destroy($id);

						DB::commit();
					} catch (Exception $e) {
						DB::rollBack();
						throw $e;
					}
					return redirect('/product');
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
	public function buy($id, Request $request)
	{
		$student_user = Auth::user();
		$type = UserController::userType($student_user->id);
		switch ($type) {
			case 'student':
				$product = Product::find($id);
				$student_id = DB::table('students')
					->where('students.user_id', '=', intval($student_user->id))
					->first()->id;
				$student = Student::find($student_id);
				if ($product && $student) {
					try {
						DB::beginTransaction();

						if ($student->balance < $product->price) {
							return back()->withErrors(['acess' => 'Saldo insuficiente']);
						}
						$student->balance -= $product->price;
						$student->save();

						DB::commit();
					} catch (Exception $e) {
						DB::rollBack();
						throw $e;
					}
					return redirect('/product');
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
