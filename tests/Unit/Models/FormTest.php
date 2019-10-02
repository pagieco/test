<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Form;
use App\Models\User;
use App\Models\FormField;
use App\Models\Enums\FormFieldType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_project()
    {
        $this->assertInstanceOf(BelongsTo::class, app(Form::class)->project());
    }

    /** @test */
    public function it_has_many_fields()
    {
        $this->assertInstanceOf(HasMany::class, app(Form::class)->fields());
    }

    /** @test */
    public function it_has_many_submissions()
    {
        $this->assertInstanceOf(HasMany::class, app(Form::class)->submissions());
    }

    /** @test */
    public function it_belongs_to_many_subscribers()
    {
        $this->assertInstanceOf(BelongsToMany::class, app(Form::class)->subscribers());
    }

    /** @test */
    public function it_can_insert_a_new_record()
    {
        $this->assertDatabaseHas('forms', [
            'id' => factory(Form::class)->create()->id,
        ]);
    }

    /** @test */
    public function it_can_get_the_profile_identifier_field()
    {
        $form = factory(Form::class)->create();

        $field = factory(FormField::class)->create([
            'type' => FormFieldType::Email,
            'form_id' => $form->id,
            'is_profile_identifier' => true,
        ]);

        $this->assertInstanceOf(FormField::class, $form->getProfileIdentifierField());
        $this->assertEquals($form->getProfileIdentifierField()->id, $field->id);
    }

    /** @test */
    public function a_user_can_subscribe_to_a_form()
    {
        $form = factory(Form::class)->create();

        $form->subscribeToNotifications(factory(User::class)->create());

        $form->refresh();

        $this->assertCount(1, $form->subscribers);

        $form->subscribeToNotifications(factory(User::class)->create());

        $form->refresh();

        $this->assertCount(2, $form->subscribers);
    }

    /** @test */
    public function a_user_can_unsubscribe_from_a_form()
    {
        $form = factory(Form::class)->create();
        $user = factory(User::class)->create();

        $form->subscribeToNotifications($user);

        $form->unsubscribeFromNotifications($user);

        $this->assertEmpty($form->subscribers);
    }
}
