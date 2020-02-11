<?php

namespace Vellum\Models\Uam;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModulePermission extends Model
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
	protected $table = 'module_permission';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['module_id', 'permission_id'];

	/*
	|--------------------------------------------------------------------------
	| Scopes
	|--------------------------------------------------------------------------
	*/

	public function scopeWhereExists($query, $moduleId, $permissionId)
    {
        return $query->where('module_id', $moduleId)
        			 ->where('permission_id', $permissionId);
    }

}
