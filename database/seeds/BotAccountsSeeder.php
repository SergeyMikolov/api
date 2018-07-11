<?php

use App\Models\Instagram\BotAccount;
use Illuminate\Database\Seeder;

class BotAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BotAccount::create([
        	'name' => 'studioapi',
			'password' => '7411328'
		]);
    }
}
