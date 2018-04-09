<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateGroupTypesTable
 */
class CreateGroupTypesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up ()
	{
		Schema::create('group_types', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name')->unique()->comment        = 'group name';
			$table->string('description')->comment = 'group description';
			$table->string('img')->comment = 'img url';
			$table->string('requirements')->comment = 'group requirements';
			$table->string('duration')->comment = 'group lesson duration';
			$table->boolean('display')->comment = 'display or not';
			$table->integer('display_order')->unique()->comment = 'display order';
		});

		DB::statement("COMMENT ON TABLE group_types IS 'Table with group types names'");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down ()
	{
		Schema::dropIfExists('group_types');
	}
}
