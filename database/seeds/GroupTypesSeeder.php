<?php

use Illuminate\Database\Seeder;

class GroupTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$groupTypes = [
			[
				'name' => 'Pole Feet',
				'description' => 'Крутится на палке'
			],
			[
				'name' => 'Acrobatic',
				'description' => 'Акробатика на палке'
			],
			[
				'name' => 'Exotic',
				'description' => 'Крутить жопой возле палки'
			],
		];

		DB::table('group_types')->insert($groupTypes);
    }
}
