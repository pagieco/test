<?php

namespace Tests\Unit\Domains\Form\Models;

use Tests\TestCase;
use App\Domains\Form\Models\FormSubmission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormSubmissionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_form()
    {
        $this->assertInstanceOf(BelongsTo::class, app(FormSubmission::class)->form());
    }

    /** @test */
    public function it_belongs_to_a_profile()
    {
        $this->assertInstanceOf(BelongsTo::class, app(FormSubmission::class)->profile());
    }

    /** @test */
    public function it_can_insert_a_new_record()
    {
        $this->assertDatabaseHas('form_submissions', [
            'id' => factory(FormSubmission::class)->create()->id,
        ]);
    }
}
