<?php

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    protected static $id = 1;

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

        static::$id = $project->id;
    }

    public static function getWildcatsProject()
    {
        return Project::findOrFail(static::$id);
    }
}
