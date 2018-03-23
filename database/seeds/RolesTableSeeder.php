<?php

use App\User;
use Illuminate\Database\Seeder;
use jeremykenedy\LaravelRoles\Models\Role;

class RolesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run ()
	{
		/*
		 * Add Roles
		 *
		 */
		if (Role::where('slug', '=', 'admin')->first() === null) {
			Role::create([
				'name'        => 'Admin',
				'slug'        => 'admin',
				'description' => 'Admin Role',
				'level'       => 5,
			]);
		}

		if (Role::where('slug', '=', 'user')->first() === null) {
			Role::create([
				'name'        => 'User',
				'slug'        => 'user',
				'description' => 'User Role',
				'level'       => 1,
			]);
		}

		if (Role::where('slug', '=', 'unverified')->first() === null) {
			Role::create([
				'name'        => 'Unverified',
				'slug'        => 'unverified',
				'description' => 'Unverified Role',
				'level'       => 0,
			]);
		}

		if (Role::where('slug', '=', 'trainer')->first() === null) {
			Role::create([
				'name'        => 'Trainer',
				'slug'        => 'trainer',
				'description' => 'Trainer Role',
				'level'       => 0,
			]);
		}

		if (Role::where('slug', '=', 'apprentice')->first() === null) {
			Role::create([
				'name'        => 'Apprentice',
				'slug'        => 'apprentice',
				'description' => 'Apprentice Role',
				'level'       => 0,
			]);
		}
	}
}
