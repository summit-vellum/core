<?php

namespace Vellum\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Quill\Post\Models\Post;
use Vellum\Contracts\FormRequestContract;
use Vellum\Contracts\Formable;
use Vellum\Contracts\Resource;
use Vellum\Module\Module;

class ResourceController extends Controller
{

    protected $resource;
    protected $resourceLock;
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

        return view('vellum::catalog', $this->data);
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

        return view('vellum::form', $this->data);
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
        $data = $this->resource->save($request->all());

        return redirect()->route($this->module->getName() . '.show', $data['id']);
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

        return view('vellum::form', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update', $this->resource->getModel()->find($id));

        // Check if module can lock content
        if (in_array($this->module->getName(), config('resource_lock'))) {

            $this->resource->getModel()->find($id)->resourceLock()->updateOrCreate([
                'user_id' => auth()->user()->id,
                'name' => auth()->user()->name
            ]);

        }

        $this->data['data'] = $this->resource->findById($id);
        $this->data['attributes'] = $this->resource->getAttributes();
        $this->data['routeUrl'] = route($this->module->getName() . '.update', $id);

        return view('vellum::form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FormRequestContract $request, $id)
    {
        $this->authorize('update', $this->resource->getModel());

        $data = $this->resource->save($request->all(), $id);

        return redirect()->route($this->module->getName() . '.show', $id);
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
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function autosave(FormRequestContract $request, $id)
    {
        $res['method'] = $request->method();
        if ($request->method() == 'PUT'){
            $this->authorize('update', $this->resource->getModel());
            $this->resource->save($request->all(), $id);
            $res['redirect'] = null;
        } else {
            $this->authorize('create', $this->resource->getModel());
            $validator = $request->validated();
            $data = $this->resource->save($request->all());
            $res['redirect'] = route($this->module->getName() . '.update', $data->id);
        }

        return response()->json($res, 200, [], JSON_NUMERIC_CHECK);
    }
}
