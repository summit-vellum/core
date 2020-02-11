<?php

namespace Vellum\Models\Uam;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
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
	protected $table = 'module';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'description', 'platform_id', 'editable'];

	/*
	|--------------------------------------------------------------------------
	| Scopes
	|--------------------------------------------------------------------------
	*/

	public function scopeWhereId($query, $name)
    {
        return $query->where('id', $name);
    }

	public function scopeWhereName($query, $name)
    {
        return $query->where('name', $name);
    }
}
