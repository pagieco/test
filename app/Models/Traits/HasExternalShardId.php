<?php

namespace App\Models\Traits;

use App\Models\Model;
use App\Http\Response;
use App\Services\IdGenerator;

trait HasExternalShardId
{
    /**
     * Retrieve the model for a bound value.
     *
     * @param  string|int  $value
     * @return \Illuminate\Database\Eloquent\Model|null
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function resolveRouteBinding($value): ?Model
    {
        return $this->where('external_id', $value)->first()
            ?? abort(Response::HTTP_NOT_FOUND);
    }

    public static function bootHasExternalShardId()
    {
        static::created(function ($model) {
            $model->external_id = IdGenerator::encode($model->project->getKey(), $model->getKey());

            $model->save();
        });
    }
}
