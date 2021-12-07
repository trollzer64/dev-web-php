<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class FoodSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$jsonfile = file_get_contents('https://www.themealdb.com/api/json/v1/1/random.php');
		$data = json_decode($jsonfile, true);
		$food = $data['meals'][0];
		$ingredients = array_fill(0, 20, "");
		foreach ($ingredients as $key => $value) {
			$ingredients[$key] = $food['strIngredient' . ($key + 1)];
		}

		DB::table('foods')->insert([
			'product_id' => DB::table('products')->pluck('id')->last(),

			'ingredients' => implode(', ', $ingredients),

			'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
			'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		]);
	}
}
