<?php

namespace Vellum\Repositories;

use App\Http\Controllers\QuillBuilderController;
use App\Repositories\Exception;
use Debugbar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Vellum\Contracts\HasCrud;
use Vellum\Contracts\Resource;
use Vellum\Module\Module;
use Vellum\Services\FileUploadService;
use Vellum\Uploader\UploadTrait;

class ResourceRepository implements Resource, HasCrud
{
    use UploadTrait;

    protected $model;
    protected $class;
    protected $uploadService;
    private $config;
    public $attributes;
    protected $modify = [];

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->attributes = app(Pipeline::class)
                    ->send([])
                    ->through($this->model->fields())
                    ->thenReturn();

        $this->attributes['collections'] = array_reverse($this->attributes['collections']);
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getActions()
    {
        return $this->model->actions();
    }

    public function getFilterFields()
    {
        return $this->model->filters();
    }

    public function getRowsData($request = [])
    {
    	return $this->model->allData(array_keys($this->attributes['collections']), $request);
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function save(array $data, int $id = 0)
    {
        // $data = FileUploadService::make($data);
        $class = get_class($this->model);
        $instance = $class::updateOrCreate(
            ['id' => $data['id'] ?? 0],
            $data
        );

        return $instance;
    }

    public function delete(int $id = 0)
    {
        if ($id === 0) {
            throw new Exception("Invalid resource id.", 1);
        }

        return $this->model->find($id)->delete();
    }
}
