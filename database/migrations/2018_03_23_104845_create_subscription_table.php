<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateSubscriptionTable
 */
class CreateSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subscription_type_id');
            $table->integer('group_type_id');
            $table->integer('price');

			$table->foreign('subscription_type_id')
				  ->references('id')
				  ->on('subscription_types')
				  ->onDelete('cascade');

			$table->foreign('group_type_id')
				  ->references('id')
				  ->on('group_types')
				  ->onDelete('cascade');
        });

		DB::statement("COMMENT ON TABLE subscription IS 'Table with subscriptions, its type and price'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription');
    }
}
