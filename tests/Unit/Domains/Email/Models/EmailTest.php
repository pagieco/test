<?php

namespace Tests\Unit\Domains\Email\Models;

use Tests\TestCase;
use App\Domains\Email\Models\Email;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_project()
    {
        $this->assertInstanceOf(BelongsTo::class, app(Email::class)->project());
    }

    /** @test */
    public function it_can_insert_a_new_record()
    {
        $this->assertDatabaseHas('emails', [
            'id' => factory(Email::class)->create()->id,
        ]);
    }
}
