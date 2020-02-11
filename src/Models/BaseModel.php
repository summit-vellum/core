<?php

namespace Vellum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Quill\Status\Models\Status;
use Illuminate\Pipeline\Pipeline;

class BaseModel extends Model
{
    use SoftDeletes;

    // protected $hidden = ['id'];
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $perPage = 5;
    protected $site = '';

    public function __construct()
    {
    	$this->site = config('site');
    }

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
        $pageLimit = request('limit', $this->site['pagination_limit']);
    	$classBaseName = get_class($this);
    	$baseModelClass = $classBaseName::query();
    	$pipeline = app(Pipeline::class)
    		->send($baseModelClass->select($fields))
    		->through(array_merge(config('filters'), $this->filters()))
    		->thenReturn()
    		->paginate($pageLimit);

    	return $pipeline;
    }
}
