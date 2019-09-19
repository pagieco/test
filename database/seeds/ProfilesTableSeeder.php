<?php

use Illuminate\Database\Seeder;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $project = ProjectsTableSeeder::getWildcatsProject();

        for ($i = 0; $i < 5000; $i++) {
            $project->profiles()->create([
                'email' => faker()->safeEmail,
                'first_name' => faker()->firstName,
                'last_name' => faker()->lastName,
                'city' => faker()->city,
                'zip' => faker()->postcode,
                'country' => faker()->country,
                'phone' => faker()->phoneNumber,
                'timezone' => faker()->timezone,
            ]);
        }
    }
}
