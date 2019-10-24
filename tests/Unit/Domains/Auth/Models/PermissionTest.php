<?php

namespace Tests\Unit\Domains\Auth\Models;

use Tests\TestCase;
use App\Domains\Auth\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_many_roles()
    {
        $this->assertInstanceOf(BelongsToMany::class, app(Permission::class)->roles());
    }

    /** @test */
    public function it_can_scope_by_slug()
    {
        factory(Permission::class, 5)->create();

        $permission = factory(Permission::class)->create([
            'slug' => 'fake-permission-slug',
        ]);

        $this->assertCount(1, Permission::bySlug($permission->slug)->get());
    }
}
