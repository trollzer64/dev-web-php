<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call([
			UserSeeder::class, AdminSeeder::class,
			UserSeeder::class, SchoolSeeder::class,
			UserSeeder::class, ResponsibleSeeder::class,
			UserSeeder::class, StudentSeeder::class,
			ProductSeeder::class,
			ProductSeeder::class,
			ProductSeeder::class,
			ProductSeeder::class,
			ProductSeeder::class,
			ProductSeeder::class,
		]);
	}
}
