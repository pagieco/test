<?php

namespace Tests\Unit\Models\Repositories;

use Tests\TestCase;
use App\Models\Profile;
use App\Models\Repositories\ProfileRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProfileRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_a_paginated_collection()
    {
        $this->login();

        $this->assertInstanceOf(LengthAwarePaginator::class, app(ProfileRepository::class)->all());
    }

    /** @test */
    public function it_wont_include_results_from_other_projects()
    {
        $this->login();

        factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        factory(Profile::class)->create();

        $this->assertCount(1, app(ProfileRepository::class)->all());
    }

    /** @test */
    public function it_sorts_on_last_seen_attribute()
    {
        $this->login();

        factory(Profile::class)->create([
            'project_id' => $this->project->id,
            'last_seen_at' => now()->subDays(2),
        ]);

        $sub1 = factory(Profile::class)->create([
            'project_id' => $this->project->id,
            'last_seen_at' => now()->subDays(1),
        ]);

        $this->assertTrue(app(ProfileRepository::class)->all()->first()->last_seen_at->equalTo($sub1->last_seen_at));
    }
}
