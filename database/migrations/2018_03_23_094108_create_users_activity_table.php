<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUsersActivityTable
 */
class CreateUsersActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_activity', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('user_id');
			$table->integer('group_id');
			$table->integer('trainer_id');
			$table->boolean('is_present');
			$table->integer('creator_id');
			$table->timestamps();

			$table->foreign('group_id')
				  ->references('id')
				  ->on('groups')
				  ->onDelete('cascade');

			$table->foreign('user_id')
				  ->references('id')
				  ->on('users')
				  ->onDelete('cascade');

			$table->foreign('trainer_id')
				  ->references('id')
				  ->on('users')
				  ->onDelete('cascade');

			$table->foreign('creator_id')
				  ->references('id')
				  ->on('users')
				  ->onDelete('cascade');

			DB::statement("COMMENT ON TABLE users_activity IS 'People activity in groups'");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_activity');
    }
}
