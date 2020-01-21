<?php

namespace Vellum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResourceLock extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'name'];

    public function resourceable()
    {
        return $this->morphTo();
    }
}
