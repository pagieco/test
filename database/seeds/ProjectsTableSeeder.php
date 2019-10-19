<?php

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    protected static $id = 2;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $project = Project::create([
            'name' => 'Wildcats',
            'hash' => '03a13d1f-656b-4dcd-900d-f29c80be3498',
            'user_id' => UsersTableSeeder::getDemoUser()->id,
        ]);

        $project->domains()->first()->update([
            'domain_name' => 'demo.pagie.local',
        ]);

        $homepage = $project->domains()->first()->pages->first();

        $homepage->update(['dom' => file_get_contents(database_path('seeds/seed-resources/pages/homepage.html'))]);

        static::$id = $project->id;
    }

    public static function getPersonalProject()
    {
        return Project::findOrFail(1);
    }

    public static function getWildcatsProject()
    {
        return Project::findOrFail(static::$id);
    }
}
