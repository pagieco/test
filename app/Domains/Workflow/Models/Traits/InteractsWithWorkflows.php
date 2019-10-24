<?php

namespace App\Domains\Workflow\Models\Traits;

use App\Domains\Workflow\Models\WorkflowTransition;
use Symfony\Component\Workflow\Workflow as SymfonyWorkflow;
use App\Domains\Workflow\Notifications\WorkflowTransitionNotification;

trait InteractsWithWorkflows
{
    /**
     * Get the current workflow state.
     *
     * @return string|null
     */
    public function getCurrentWorkflowState(): ?string
    {
        return $this->getAttribute('current_workflow_state');
    }

    /**
     * Set the current workflow state.
     *
     * @param  string $state
     * @return void
     */
    public function setCurrentWorkflowState(string $state): void
    {
        $this->current_workflow_state = $state;

        $this->save();
    }

    /**
     * Apply the given transition to the current subject.
     *
     * @param  \Symfony\Component\Workflow\Workflow $workflow
     * @param  \App\Domains\Workflow\Models\WorkflowTransition $transition
     * @return void
     */
    public function transition(SymfonyWorkflow $workflow, WorkflowTransition $transition): void
    {
        $workflow->apply($this, (string) $transition->id);

        foreach ($transition->subscribers as $subscriber) {
            $subscriber->notify(new WorkflowTransitionNotification($transition));
        }
    }

    /**
     * Determine that the subject can transition to the new step.
     *
     * @param  \Symfony\Component\Workflow\Workflow $workflow
     * @param  \App\Domains\Workflow\Models\WorkflowTransition $transition
     * @return bool
     */
    public function canTransition(SymfonyWorkflow $workflow, WorkflowTransition $transition): bool
    {
        return $workflow->can($this, (string) $transition->id);
    }
}
