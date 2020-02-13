<?php

namespace Vellum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Autosaves extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'values'];

    // public function resourceable()
    // {
    //     return $this->morphTo();
    // }
}
