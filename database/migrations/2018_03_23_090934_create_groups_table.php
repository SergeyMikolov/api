<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateGroupsTable
 */
class CreateGroupsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up ()
	{
		Schema::create('groups', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_group_type_id')->comment       = 'Group type';
			$table->integer('day_id')->comment                   = 'day id';
			$table->time('training_time')->comment               = 'training time of the day';
			$table->integer('capacity')->comment                 = 'current group capacity';
			$table->integer('max_capacity')->comment             = 'max group capacity';
			$table->boolean('is_active')->default(true)->comment = 'group is active';

			$table->foreign('user_group_type_id')
				  ->references('id')
				  ->on('user_group_type')
				  ->onDelete('cascade');

			$table->foreign('day_id')
				  ->references('id')
				  ->on('days')
				  ->onDelete('cascade');

		});

		DB::statement("COMMENT ON TABLE groups IS 'Table with groups data names'");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down ()
	{
		Schema::dropIfExists('groups');
	}
}
