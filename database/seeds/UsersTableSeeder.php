<?php

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use jeremykenedy\LaravelRoles\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $profile = new Profile();
        $adminRole = Role::whereName('Admin')->first();
        $userRole = Role::whereName('User')->first();
        $trainerRole = Role::whereName('Trainer')->first();
        $apprenticeRole = Role::whereName('Apprentice')->first();

        // Seed test admin
        $seededAdminEmail = 'admin@admin.com';
        $user = User::where('email', '=', $seededAdminEmail)->first();
        if ($user === null) {
            $user = User::create([
                'name'                           => $faker->userName,
                'first_name'                     => $faker->firstName,
                'last_name'                      => $faker->lastName,
                'email'                          => $seededAdminEmail,
                'password'                       => Hash::make('password'),
                'token'                          => str_random(64),
                'activated'                      => true,
                'signup_confirmation_ip_address' => $faker->ipv4,
                'admin_ip_address'               => $faker->ipv4,
            ]);

            $user->profile()->save($profile);
            $user->attachRole($adminRole);
            $user->save();
        }

        // Seed test user
        $user = User::where('email', '=', 'user@user.com')->first();
        if ($user === null) {
            $user = User::create([
                'name'                           => $faker->userName,
                'first_name'                     => $faker->firstName,
                'last_name'                      => $faker->lastName,
                'email'                          => 'user@user.com',
                'password'                       => Hash::make('password'),
                'token'                          => str_random(64),
                'activated'                      => true,
                'signup_ip_address'              => $faker->ipv4,
                'signup_confirmation_ip_address' => $faker->ipv4,
            ]);

            $user->profile()->save(new Profile());
            $user->attachRole($userRole);
            $user->save();
        }

		// Seed  test trainer
		$user = User::where('email', '=', 'trainer@user.com')->first();
		if ($user === null) {
			$user = User::create([
				'name'                           => $faker->userName,
				'first_name'                     => $faker->firstName,
				'last_name'                      => $faker->lastName,
				'email'                          => 'trainer@user.com',
				'password'                       => Hash::make('password'),
				'token'                          => str_random(64),
				'activated'                      => true,
				'signup_ip_address'              => $faker->ipv4,
				'signup_confirmation_ip_address' => $faker->ipv4,
			]);

			$user->profile()->save(new Profile());
			$user->attachRole($trainerRole);
			$user->save();
		}

		// Seed  test Apprentice
		$user = User::where('email', '=', 'apprentice1@user.com')->first();
		if ($user === null) {
			$user = User::create([
				'name'                           => $faker->userName,
				'first_name'                     => $faker->firstName,
				'last_name'                      => $faker->lastName,
				'email'                          => 'apprentice1@user.com',
				'password'                       => Hash::make('password'),
				'token'                          => str_random(64),
				'activated'                      => true,
				'signup_ip_address'              => $faker->ipv4,
				'signup_confirmation_ip_address' => $faker->ipv4,
			]);

			$user->profile()->save(new Profile());
			$user->attachRole($apprenticeRole);
			$user->save();
		}

		$user = User::where('email', '=', 'apprentice2@user.com')->first();
		if ($user === null) {
			$user = User::create([
				'name'                           => $faker->userName,
				'first_name'                     => $faker->firstName,
				'last_name'                      => $faker->lastName,
				'email'                          => 'apprentice2@user.com',
				'password'                       => Hash::make('password'),
				'token'                          => str_random(64),
				'activated'                      => true,
				'signup_ip_address'              => $faker->ipv4,
				'signup_confirmation_ip_address' => $faker->ipv4,
			]);

			$user->profile()->save(new Profile());
			$user->attachRole($apprenticeRole);
			$user->save();
		}

        // Seed test users
        // $user = factory(App\Models\Profile::class, 5)->create();
        // $users = User::All();
        // foreach ($users as $user) {
        //     if (!($user->isAdmin()) && !($user->isUnverified())) {
        //         $user->attachRole($userRole);
        //     }
        // }
    }
}
