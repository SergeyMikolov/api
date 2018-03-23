<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePaymentsTable
 */
class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('subscription_id');
            $table->integer('creator_id');
            $table->timestamps();

			$table->foreign('user_id')
				  ->references('id')
				  ->on('users')
				  ->onDelete('cascade');

			$table->foreign('subscription_id')
				  ->references('id')
				  ->on('subscriptions')
				  ->onDelete('cascade');

			$table->foreign('creator_id')
				  ->references('id')
				  ->on('users')
				  ->onDelete('cascade');
        });

		DB::statement("COMMENT ON TABLE payments IS 'Table with users payments for subscription'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
