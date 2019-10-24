<?php

namespace App\Domains\Workflow\Models;

use App\Models\Model;
use Symfony\Component\Workflow\Transition;
use Symfony\Component\Workflow\DefinitionBuilder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Domains\Project\Models\Traits\BelongsToProject;
use Symfony\Component\Workflow\Workflow as SymfonyWorkflow;
use Symfony\Component\Workflow\MarkingStore\MethodMarkingStore;

class Workflow extends Model
{
    use BelongsToProject;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'workflows';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description',
    ];

    /**
     * Get the steps that belong to this workflow.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function steps(): HasMany
    {
        return $this->hasMany(WorkflowStep::class);
    }

    /**
     * Get the transitions that belong to this workflow.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transitions(): HasMany
    {
        return $this->hasMany(WorkflowTransition::class);
    }

    /**
     * Create a new step.
     *
     * @param  string $name
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createStep($name): Model
    {
        $step = new WorkflowStep(['name' => $name]);

        $step->project()->associate($this->project);
        $step->workflow()->associate($this);

        return tap($step)->save();
    }

    /**
     * Create a new transition for the given workflow.
     *
     * @param  \App\Domains\Workflow\Models\WorkflowStep $from
     * @param  \App\Domains\Workflow\Models\WorkflowStep $to
     * @return \App\Domains\Workflow\Models\WorkflowTransition
     */
    public function createTransition(WorkflowStep $from, WorkflowStep $to): WorkflowTransition
    {
        $transition = new WorkflowTransition;

        $transition->workflow()->associate($this);
        $transition->project()->associate($this->project);
        $transition->from()->associate($from);
        $transition->to()->associate($to);

        return tap($transition)->save();
    }

    /**
     * Build a new workflow object.
     *
     * @return \Symfony\Component\Workflow\Workflow
     */
    public function build(): SymfonyWorkflow
    {
        // Map over each step to create an array of step id's.
        $steps = $this->steps->map->id->toArray();

        // Map over each transition to create an array of workflow transitions.
        $transitions = $this->transitions->map(function ($transition) {
            return new Transition($transition->id, $transition->from_id, $transition->to_id);
        })->toArray();

        $builder = new DefinitionBuilder($steps, $transitions);

        return new SymfonyWorkflow(
            $builder->build(),
            new MethodMarkingStore(true, 'currentWorkflowState')
        );
    }
}
