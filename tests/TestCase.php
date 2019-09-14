<?php

namespace Tests;

use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $defaultHeaders = [
        'X-Requested-With' => 'XMLHttpRequest',
    ];

    protected function login(User $user = null): User
    {
        if (is_null($user)) {
            $user = factory(User::class)->create();
        }

        $project = factory(Project::class)->create();

        $user->switchToProject($project);

        $this->actingAs($user);

        return $user;
    }
}
