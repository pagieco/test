<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Domains\Profile\Models\ProfileEvent;
use App\Domains\Profile\Enums\ProfileEventType;

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

        for ($i = 0; $i < 100; $i++) {
            DB::transaction(function () use ($project) {
                $profile = $project->profiles()->create([
                    'email' => faker()->email,
                    'first_name' => faker()->firstName,
                    'last_name' => faker()->lastName,
                    'city' => faker()->city,
                    'zip' => faker()->postcode,
                    'country' => faker()->country,
                    'phone' => faker()->phoneNumber,
                    'timezone' => faker()->timezone,
                ]);

                for ($j = 0; $j < rand(2, 10); $j++) {
                    $event = new ProfileEvent([
                        'event_type' => ProfileEventType::randomValue(),
                    ]);
                    $event->project()->associate($project);
                    $event->profile()->associate($profile);
                    $event->save();
                }
            });
        }
    }
}
