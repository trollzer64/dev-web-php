<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$jsonfile = file_get_contents('https://randomuser.me/api/');
		$data = json_decode($jsonfile, true);
		$results = $data['results'][0];

		DB::table('users')->insert([
			'email' => $results['email'],
			'login' => $results['login']['username'],
			'password' => Hash::make('Cantina_10'),

			'name' => implode(' ', $results['name']),
			'phone' => $results['phone'],

			'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
			'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		]);
	}
}
