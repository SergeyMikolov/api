<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateSubscriptionTypesTable
 */
class CreateSubscriptionTypesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up ()
	{
		Schema::create('subscription_types', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name')->comment           = 'subscription name';
			$table->string('description')->comment    = 'subscription description';
			$table->integer('lessons_count')->comment = 'lessons count od current subscription';
		});

		DB::statement("COMMENT ON TABLE subscription_types IS 'Table with subscription and its counts of lessons'");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down ()
	{
		Schema::dropIfExists('subscription_types');
	}
}
