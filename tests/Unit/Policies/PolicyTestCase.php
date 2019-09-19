<?php

namespace Tests\Unit\Policies;

use Tests\TestCase;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

abstract class PolicyTestCase extends TestCase
{
    /**
     * The policy implementation.
     *
     * @var string
     */
    protected $policy;

    /** @test */
    public function it_correctly_reflects_the_list_of_policies()
    {
        $group = $this->policyGroup();

        foreach (get_class_methods($this->policy) as $method) {
            $policy = sprintf('%s:%s', $group, Str::snake($method, '-'));

            $this->assertNotNull(
                Arr::get(config('auth.permissions'), $policy),
                sprintf('Unreflected policy found: %s.', $policy),
            );
        }
    }

    protected function policyGroup(): string
    {
        $basename = class_basename($this->policy);

        if (Str::endsWith($basename, 'Policy')) {
            $basename = substr($basename, 0, -6);
        }

        return Str::snake($basename, '-');
    }
}
