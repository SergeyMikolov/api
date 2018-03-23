<?php

use Illuminate\Database\Seeder;

class SubscriptionsTypesSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run ()
	{
		$subscriptionsTypes = [
			[
				'name'          => 'Дневной',
				'description'   => 'Дневное абонимент',
				'lessons_count' => 1,
			],
			[
				'name'          => 'Месячный',
				'description'   => 'Месячный абонимент на 30 дней',
				'lessons_count' => 8,
			],
			[
				'name'          => 'Годовой',
				'description'   => 'Годовой абонимент на 360 дней',
				'lessons_count' => 100,
			],
		];

		DB::table('subscription_types')->insert($subscriptionsTypes);
	}
}
