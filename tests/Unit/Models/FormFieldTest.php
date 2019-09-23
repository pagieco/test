<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\FormField;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormFieldTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_form()
    {
        $this->assertInstanceOf(BelongsTo::class, app(FormField::class)->form());
    }

    /** @test */
    public function it_can_insert_a_new_record()
    {
        $this->assertDatabaseHas('form_fields', [
            'id' => factory(FormField::class)->create()->id,
        ]);
    }
}
