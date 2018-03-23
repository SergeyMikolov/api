<?php

use App\Models\Day;
use Illuminate\Database\Seeder;

/**
 * Class DaysTableSeeder
 */
class DaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $days = collect(Day::$items)->map(function($day) {
        	return [
        		'name' => $day
			];
		})->toArray();

        DB::table('days')->insert($days);
    }
}
