<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\ProfileEvent;
use Illuminate\Http\Request;
use App\Http\Router\Resolver;
use Illuminate\Support\Facades\Cookie;

class FrontendController
{
    const HALF_YEAR_IN_MINUTES = 60 * 24 * 365 / 2;

    public function __invoke(Request $request)
    {
        $resolver = new Resolver($request);

        $resolver->resolveDomain();

        return $resolver->resolveResource()
            ->toResponse($request)
            ->with($this->prepareResponseData($resolver));
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

    protected function identifyProfile(Resolver $resolver): ?Profile
    {
        $project = $resolver->domain->project;

        if ($profile = Profile::identify($resolver->request, $project)) {
            Cookie::queue('profile_id', $profile->profile_id, static::HALF_YEAR_IN_MINUTES);
        }

        return $profile;
    }
}
