<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTrainersTable
 */
class CreateTrainersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up ()
	{
		Schema::create('trainers_info', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')
				  ->unique();
			$table->text('description');
			$table->string('img');
			$table->boolean('display')
				  ->default(false);
			$table->integer('display_order');
			$table->timestamps();

			$table->foreign('user_id')
				  ->references('id')->on('users')
				  ->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down ()
	{
		Schema::dropIfExists('trainers_info');
	}
}
