<?php

namespace Tests\Unit\Http\Router;

use Tests\TestCase;
use Illuminate\Http\Request;
use App\Http\Router\Resolver;
use App\Domains\Page\Models\Page;
use App\Domains\Domain\Models\Domain;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ResolverTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_throws_a_model_not_found_exception_when_the_domain_could_not_be_found()
    {
        $this->expectException(ModelNotFoundException::class);

        $request = Request::create(faker()->url);

        $resolver = new Resolver($request);

        $resolver->resolveDomain();
    }

    /** @test */
    public function it_correctly_resolves_the_domain()
    {
        factory(Domain::class)->create([
            'domain_name' => 'test-domain.com',
        ]);

        $request = Request::create('https://test-domain.com/test-uri');

        $resolver = new Resolver($request);

        $this->assertInstanceOf(Domain::class, $resolver->resolveDomain());
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_no_resource_could_be_found()
    {
        $this->expectException(NotFoundHttpException::class);

        factory(Domain::class)->create([
            'domain_name' => 'test-domain.com',
        ]);

        $request = Request::create('https://test-domain.com/test-uri');

        $resolver = new Resolver($request);

        $resolver->resolveDomain();

        $resolver->resolveResource();
    }

    /** @test */
    public function it_correctly_returns_the_matched_resource_when_resolving_the_request()
    {
        $domain = factory(Domain::class)->create([
            'domain_name' => 'test-domain.com',
        ]);

        $page = factory(Page::class)->create([
            'project_id' => $domain->project_id,
            'domain_id' => $domain->id,
        ]);

        $request = Request::create('https://test-domain.com/'.$page->slug);

        $resolver = new Resolver($request);

        $resolver->resolveDomain();

        $this->assertInstanceOf(Page::class, $resolver->resolveResource());
    }
}
