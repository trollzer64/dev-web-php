<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class StudentSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('students')->insert([
			'user_id' => DB::table('users')->pluck('id')->last(),
			'responsible_id' => DB::table('responsibles')->pluck('id')->random(),
			'school_id' => DB::table('schools')->pluck('id')->random(),

			'registration' => strval(rand(100000, 999999)),
			'class' => Str::random(3),
			'shift' => 'matutino',

			'balance' => 0.0,

			'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
			'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		]);
	}
}
