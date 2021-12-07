<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class ProductSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{


		$id = DB::table('products')->pluck('id')->count();
		if ($id % 2 === 0) {
			$type = 'drink';
			$jsonfile = file_get_contents('https://www.thecocktaildb.com/api/json/v1/1/random.php');
			$data = json_decode($jsonfile, true);
			$food = $data['drinks'][0];

			$name = $food['strDrink'];
			$image = $food['strDrinkThumb'];
			$ingredients = null;
			$provider = $food['strGlass'];
			$code = $food['idDrink'];
		} else {
			$type = 'food';
			$jsonfile = file_get_contents('https://www.themealdb.com/api/json/v1/1/random.php');
			$data = json_decode($jsonfile, true);
			$food = $data['meals'][0];

			$name = $food['strMeal'];
			$image = $food['strMealThumb'];
			$provider = null;
			$ingredients = array_fill(0, 20, "");
			foreach ($ingredients as $key => $value) {
				$ingredient = $food['strIngredient' . ($key + 1)];
				$ingredients[$key] = $ingredient;
			}
			$code = $food['idMeal'];
		}

		DB::table('products')->insert([
			'code' => $code,

			'name' => $name,
			'photo' => $image,
			'price' => rand(50, 1500) / 100,
			'type' => $type,

			'ingredients' => $type === 'drink' ? null : implode(', ', $ingredients),
			'provider' => $type === 'food' ? null : $provider,

			'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
			'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		]);
	}
}
