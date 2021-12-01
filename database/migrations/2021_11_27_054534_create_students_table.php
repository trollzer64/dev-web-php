<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('students', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->constrained('users')->onDelete('cascade');
			$table->foreignId('responsible_id')->constrained('responsibles')->onDelete('cascade');
			$table->foreignId('school_id')->constrained('schools')->onDelete('cascade');

			$table->string('registration')->unique();
			$table->string('class');
			$table->enum('shift', ['matutino', 'vespertino', 'noturno']);

			$table->decimal('balance');

			$table->timestampsTz();
			// $table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('students');
	}
}
