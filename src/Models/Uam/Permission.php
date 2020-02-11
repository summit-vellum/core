<?php

namespace Vellum\Models\Uam;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    /**
     * The database connection used by the model.
     *
     * @var string
     */
    protected $connection = 'uam';

    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'permission';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'description'];


	/*
	|--------------------------------------------------------------------------
	| Scopes
	|--------------------------------------------------------------------------
	*/

	public function scopeWhereName($query, $name)
    {
        return $query->where('name', $name);
    }
}
