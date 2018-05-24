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
			$table->string('slug')
				  ->unique()->comment           = 'group slug';
			$table->string('display_name')
				  ->unique()->comment           = 'group display_name';
			$table->text('description')
				  ->comment           = 'group description';
			$table->string('img')->comment      = 'img url';
			$table->string('requirements')
				  ->nullable()->comment         = 'group requirements';
			$table->string('duration')
				  ->nullable()->comment         = 'group lesson duration';
			$table->boolean('display')->default(false)->comment = 'display or not';
			$table->integer('display_order')
				  ->nullable()
//				  ->unique() todo сделать уникальными
				->comment           = 'display order';
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
