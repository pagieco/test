<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Domains\Page\Models\Page;
use App\Domains\Workflow\Models\Workflow;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Domains\Workflow\Notifications\WorkflowTransitionNotification;

class WorkflowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_wow()
    {
        Notification::fake();

        $this->login();

        /** @var \App\Domains\Workflow\Models\Workflow $workflow */
        $workflow = factory(Workflow::class)->create();

        $draft = $workflow->createStep('Draft');
        $reviewed = $workflow->createStep('Reviewed');
        $rejected = $workflow->createStep('Rejected');
        $published = $workflow->createStep('Published');

        // to review
        $toReviewTransition = $workflow->createTransition($draft, $reviewed);
        $toReviewTransition->subscribers()->attach($this->user);

        // publish
        $publishTransition = $workflow->createTransition($reviewed, $published);

        // reject
        $rejectTransition = $workflow->createTransition($reviewed, $rejected);

        $w = $workflow->build();

        $subject = factory(Page::class)->create();

        $this->assertFalse($subject->canTransition($w, $publishTransition));
        $this->assertTrue($subject->canTransition($w, $toReviewTransition));

        $subject->transition($w, $toReviewTransition);

        Notification::assertSentTo($this->user, WorkflowTransitionNotification::class);

        $this->assertTrue($subject->canTransition($w, $publishTransition));
        $this->assertTrue($subject->canTransition($w, $rejectTransition));
    }
}
