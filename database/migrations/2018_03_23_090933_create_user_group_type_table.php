<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUserGroupTypeTable
 */
class CreateUserGroupTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_group_type', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('group_type_id');

			$table->foreign('group_type_id')
				  ->references('id')
				  ->on('group_types')
				  ->onDelete('cascade');

			$table->foreign('user_id')
				  ->references('id')
				  ->on('users')
				  ->onDelete('cascade');

			$table->unique('user_id', 'group_type_id');
        });

		DB::statement("COMMENT ON TABLE user_group_type IS 'Relation between trainer and groups that he can lead'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_group_type');
    }
}
