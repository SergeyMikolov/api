<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBotAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bot_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique()->comment = 'User name';
            $table->string('password')->comment = 'User password';
            $table->timestamps();
        });

		DB::statement("COMMENT ON TABLE bot_accounts IS 'Table with bot accounts in Instagram'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bot_accounts');
    }
}
