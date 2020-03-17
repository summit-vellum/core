<?php

namespace Vellum\Models;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Quill\Status\Models\Status;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

class BaseModel extends Model
{
    use SoftDeletes;

    // protected $hidden = ['id'];
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $perPage = 5;

    /**
     * Retrieves an eloquent relationships nested property
     * from a column.
     *
     * @param string $column
     *
     * @return mixed
     */
    public function getRelationshipProperty($column)
    {
        $attributes = explode('.', $column);

        $tmpStr = $this;

        foreach ($attributes as $attribute) {
            if ($attribute === end($attributes)) {
                if (is_object($tmpStr)) {
                    $tmpStr = $tmpStr->$attribute;
                }
            } else {
                $tmpStr = $this->$attribute;
            }
        }

        return $tmpStr;
    }

    /**
     * Retrieves an eloquent relationship object from a column.
     *
     * @param string $column
     *
     * @return mixed
     */
    public function getRelationshipObject($column)
    {
        $attributes = explode('.', $column);

        if (count($attributes) > 1) {
            $relationship = $attributes[count($attributes) - 2];
        } else {
            $relationship = $attributes[count($attributes) - 1];
        }

        return $this->$relationship;
    }

    public function status()
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    public function allData(array $fields, $request)
    {
    	$module = request()->segment(1);
    	$module = Str::studly(Str::slug($module, '_'));
    	$tableName = ($module) ? Str::snake(Str::plural($module)) : '';

    	foreach ($fields as $key => $field) {
    		if (!Schema::hasColumn($tableName, $field)) {
	    		unset($fields[$key]);
			}
    	}

    	$site = config('site');
        $pageLimit = request('limit', $site['pagination_limit']);
    	$classBaseName = get_class($this);
    	$baseModelClass = $classBaseName::query();
    	$pipeline = app(Pipeline::class)
    		->send($baseModelClass->select($fields))
    		->through(array_merge(config('filters'), $this->filters()))
    		->thenReturn()
    		->withTrashed()
    		->paginate($pageLimit);

    	return $pipeline;
    }
}
