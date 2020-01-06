<?php

namespace Vellum\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model 
{
    // protected $hidden = ['id'];
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
