<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateBotAccountsTable
 */
class CreateBotAccountsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up ()
	{
		Schema::create('bot_accounts', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name')
			      ->unique();
			$table->string('email')
			      ->nullable();
			$table->string('password');
			$table->timestamps();
		});

		DB::statement("COMMENT ON TABLE bot_accounts IS 'Bot accounts in Instagram'");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down ()
	{
		Schema::dropIfExists('bot_accounts');
	}
}
