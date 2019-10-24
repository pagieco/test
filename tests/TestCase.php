<?php

namespace Tests;

use App\Domains\Auth\Models\Role;
use App\Domains\User\Models\User;
use Illuminate\Support\Facades\Event;
use App\Domains\Project\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $user;
    protected $project;

    /**
     * The user's admin role.
     *
     * @var null|\App\Domains\Auth\Models\Role
     */
    protected $role = null;

    protected function fakeModelEvents()
    {
        $initialDispatcher = Event::getFacadeRoot();

        Event::fake();
        Model::setEventDispatcher($initialDispatcher);
    }

    protected function login(User $user = null): User
    {
        if (is_null($user)) {
            $user = factory(User::class)->create();
        }

        $project = factory(Project::class)->create();

        $project->shareWith($user);

        $this->user = $user;
        $this->project = $project;

        $user->switchToProject($project);

        $this->actingAs($user);

        $this->assignAdminRoleToUser();

        return $user;
    }

    protected function assignAdminRoleToUser()
    {
        $role = new Role([
            'name' => 'Admin',
        ]);

        $role->project()->associate($this->project);
        $role->save();

        $this->user->assignRole($role->id);

        $this->role = $role;
    }
}
