<?php

use Illuminate\Database\Seeder;
use App\Models\Enums\ProfileEventType;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \ReflectionException
     */
    public function run()
    {
        $project = ProjectsTableSeeder::getWildcatsProject();
        $values = ProfileEventType::getValues();

        for ($i = 0; $i < 5000; $i++) {
            $profile = $project->profiles()->create([
                'email' => faker()->safeEmail,
                'first_name' => faker()->firstName,
                'last_name' => faker()->lastName,
                'city' => faker()->city,
                'zip' => faker()->postcode,
                'country' => faker()->country,
                'phone' => faker()->phoneNumber,
                'timezone' => faker()->timezone,
            ]);

            for ($j = 0; $j < rand(2, 10); $j++) {
                $profile->events()->create([
                    'event_type' => $values[array_rand($values)],
                ]);
            }
        }
    }
}
