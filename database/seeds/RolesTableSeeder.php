<?php

use Illuminate\Database\Seeder;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createRoleForPersonalProject();
        $this->createRoleForWildcatsProject();
    }

    protected function createRoleForPersonalProject()
    {
        $role = new Role([
            'name' => 'Super Admin',
            'description' => '!!(For internal use only)!!',
        ]);

        $role->project()->associate(ProjectsTableSeeder::getPersonalProject());
        $role->save();

        Permission::all()->each(function (Permission $permission) use ($role) {
            $permission->roles()->attach($role);
        });

        UsersTableSeeder::getDemoUser()->roles()->attach($role);
    }

    protected function createRoleForWildcatsProject()
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
