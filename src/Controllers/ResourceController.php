<?php

namespace Vellum\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Quill\Post\Models\Post;
use Vellum\Controllers\AutosaveController;
use Vellum\Contracts\FormRequestContract;
use Vellum\Contracts\Formable;
use Vellum\Contracts\Resource;
use Vellum\Module\Module;
use Illuminate\Support\Str;

use Gate;

class ResourceController extends Controller
{

    protected $resource;
    protected $resourceLock;
    protected $autosaves;
    public $currentRouteName;
    public $data = [];
    public $module;

    public function __construct(Resource $resource, Module $module)
    {
        if (!$resource) return null;

        $this->middleware('auth');

        $this->currentRouteName = Route::getCurrentRoute()->getName();
        $this->resource = $resource;
        $this->data['model'] = $this->resource->getModel();
        $this->data['actions'] = $this->resource->getActions();
        $this->module = $module;

        view()->composer('*', function ($view) {
            $view->with('routeName', $this->currentRouteName);
        });

        // dd($this->resource->getAttributes());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', $this->resource->getModel());

        $this->data['collections'] = $this->resource->getRowsData($request);
        $this->data['attributes'] = $this->resource->getAttributes();
        $this->data['module'] = $this->module;

        $searchables = [];
        if (isset($this->data['attributes']['searchable'])) {
        	foreach ($this->data['attributes']['searchable'] as $key => $searchable) {
        		$searchables[] = $this->data['attributes']['name'][$searchable];
        	}
        }

        $this->data['searchables'] = $searchables;

        return template('catalog', $this->data, $this->module->getName());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', $this->resource->getModel());

        $this->data['data'] = [];
        $this->data['routeUrl'] = route($this->module->getName() . '.store');
        $this->data['attributes'] = $this->resource->getAttributes();
        $this->data['module'] = $this->module;

        // $this->data['data'] = factory(\Quill\Post\Models\Post::class)->make();
        // $this->data['data']['id'] = null;
        // $this->data['data']['published_at'] = \Carbon\Carbon::now()->toDateTimeString();

        return template('form', $this->data, $this->module->getName());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormRequestContract $request)
    {
        $this->authorize('create', $this->resource->getModel());

        $validator = $request->validated();
        $fields = $request->except($this->resource->getExcludedFields());
        $data = $this->resource->save($fields);
        $id = $data->id;

        //return redirect()->route($this->module->getName() . '.index');
        return redirect()->route($this->module->getName().'.edit', $id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', $this->resource->getModel());

        $this->data['attributes'] = $this->resource->getAttributes();
        $this->data['data'] = $this->resource->findById($id);
        $this->data['routeUrl'] = route($this->module->getName() . '.update', $id);

        return template('form', $this->data, $this->module->getName());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
    	//dd($this->resource->getModel()->onlyTrashed()->find(70048));
        $this->authorize('update', $this->resource->getModel()->find($id));

        // Check if module can lock content
        if (in_array($this->module->getName(), config('resource_lock'))) {
            $this->resource->getModel()->find($id)->resourceLock()->updateOrCreate([
                'user_id' => auth()->user()->id,
                'name' => auth()->user()->name
            ]);

            if ($this->resource->getModel()->find($id)->resourceLock->user->id != auth()->user()->id) {
            	abort('403', $this->resource->getModel()->find($id)->resourceLock->user->name.' is currently editing this article');
            }
        }


        $this->data['data'] = $this->resource->findById($id);
        $this->data['isLocked'] = isset($this->data['data']->resourceLock) ? true : false;

        // Check if module can lock autosaved content
        if (in_array($this->module->getName(), config('autosave'))) {

            if($request['autosave']){
                $autosave = $this->resource->getModel()
                    ->find($id)
                    ->autosaves()
                    ->where('autosavable_id', $id)
                    ->first();

                if($autosave){
                    $autosaveData = json_decode(json_encode(unserialize($autosave['values'])));
                    $this->data['data'] = $autosaveData;

                    $this->resource->getModel()
                        ->find($id)
                        ->autosaves()
                        ->forceDelete();
                }
            }

            if (isset($this->resource->getModel()->find($id)->autosaves) && $this->resource->getModel()->find($id)->autosaves->user_id != auth()->user()->id) {
            	abort('403', 'This form is currently autosaved');
            }
        }

        $this->data['attributes'] = $this->resource->getAttributes();
        $this->data['routeUrl'] = route($this->module->getName() . '.update', $id);

        return template('form', $this->data, $this->module->getName());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FormRequestContract $request, AutosaveController $autosave, $id)
    {
        $this->authorize('update', $this->resource->getModel());

        if (in_array($this->module->getName(), config('resource_lock'))) {
	        $this->unlock($id);
	    }

        $fields = $request->except($this->resource->getExcludedFields());
        $data = $this->resource->save($fields, $id);

        if (in_array($this->module->getName(), config('autosave'))) {
            $autosave->destroy($id);
        }

        $overrideModule = isset($this->module->overrideModule) ? $this->module->overrideModule : ucfirst(str_replace('-', ' ', $this->module->module));
        session()->flash('flash_message', ucfirst($overrideModule).' saved!');

        return redirect()->route($this->module->getName().'.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', $this->resource->getModel()->find($id));

        if (in_array($this->module->getName(), config('resource_lock'))) {
	        $this->unlock($id);
	    }

        $this->resource->delete($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unlock($id)
    {
        $this->resource->getModel()->find($id)->resourceLock()->forceDelete();
    }

    /**
     * Check if the value of the field is unique
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function checkUnique(Request $request)
    {
        $name = $request->input('name', false);
        $value = $request->input('value', false);
        $slug = $request->input('slug', '');
        $res['count'] = true;

    	$data = $this->resource->getModel()->where($name, $value)->count();
        if ($data) {
            $res['count'] = false;
        } else {
        	$data = $this->resource->getModel()->where('slug', $slug)->count();
        	if ($data) {
        		$res['count'] = false;
        	}
        }

        return response()->json($res, 200, [], JSON_NUMERIC_CHECK);
    }

    /**
     * Convert value to slug
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function toSlug(Request $request)
    {
        $value = $request->input('value', false);

        if($value) {
            $res['slug'] = Str::slug($value);
        }

        return response()->json($res, 200, [], JSON_NUMERIC_CHECK);
    }
}
