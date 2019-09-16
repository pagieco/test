<?php

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role([
            'name' => 'Super Admin',
            'description' => '!!(For internal use only)!!',
        ]);

        $role->project()->associate(ProjectsTableSeeder::getWildcatsProject());
        $role->save();

        Permission::all()->each(function (Permission $permission) use ($role) {
            $permission->roles()->attach($role);
        });

        UsersTableSeeder::getDemoUser()->roles()->attach($role);
    }
}
