<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Router\Resolver;
use Illuminate\Support\Facades\Cookie;
use App\Domains\Profile\Models\Profile;
use App\Domains\Profile\Models\ProfileEvent;
use Illuminate\Contracts\Support\Responsable;

class FrontendController extends Controller
{
    const HALF_YEAR_IN_MINUTES = 60 * 24 * 365 / 2;

    /**
     * @var \App\Domains\Page\Models\Page
     */
    protected $resource;

    public function __invoke(Request $request)
    {
        $resolver = new Resolver($request);

        $resolver->resolveDomain();

        $this->resource = $resolver->resolveResource();

        return $this->respondWith(
            $this->getContents($resolver)
        );
    }

    protected function getContents($resolver)
    {
        $resource = $this->resource;

        $responseData = $this->prepareResponseData($resolver);

        return $resource->toResponse(request())->with($responseData);
    }

    protected function respondWith($contents)
    {
        $headers = $this->prepareResponseHeaders($this->resource);

        return response($contents->render())->withHeaders($headers);
    }

    protected function prepareResponseData(Resolver $resolver): array
    {
        $data = [];

        if ($profile = $this->identifyProfile($resolver)) {
            ProfileEvent::recordVisitedPage($profile);

            $data['profile'] = $profile;
        }

        return $data;
    }

    protected function prepareResponseHeaders(Responsable $resource)
    {
        $headers = [];

        if ($resource->published_at) {
            $headers['Last-Modified'] = $resource->published_at->toRfc7231String();
        }

        return $headers;
    }

    protected function identifyProfile(Resolver $resolver): ?Profile
    {
        $project = $resolver->domain->project;

        if ($profile = Profile::identify($resolver->request, $project)) {
            Cookie::queue('profile_id', $profile->profile_id, static::HALF_YEAR_IN_MINUTES);
        }

        return $profile;
    }
}
