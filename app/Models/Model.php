<?php

namespace App\Models;

use App\Services\IdGenerator;
use Illuminate\Database\Eloquent\Model as BaseModel;

abstract class Model extends BaseModel
{
//    public function getShardIdAttribute(): int
//    {
//        return IdGenerator::encode($this->project_id, $this->getKey());
//    }
}
