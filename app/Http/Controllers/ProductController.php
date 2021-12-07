<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
	public function save(Request $request){

	}
	public function edit($id, Request $request) {

	}
	public function delete($id, Request $request){
		
	}
}
