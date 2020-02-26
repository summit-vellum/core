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

class AutosaveController extends Controller
{

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
    public function index()
    {
        dd('index');
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FormRequestContract $request)
    {
        $res['status'] = 'not in config';
        
        if (in_array($this->module->getName(), config('autosave'))) {
            $this->authorize('create', $this->resource->getModel());
            $validator = $request->validated();
            $data = $this->resource->save($request->all());
            $res['id'] = $id = $data->id;
            $res['newMethod'] = 'PUT';
            $res['status'] = 'saved';

            $this->resource->getModel()->find($id)->autosaves()->updateOrCreate(
                ['autosavable_id' => $id],
                [
                    'values' => serialize($request->all()),
                    'user_id' => auth()->user()->id
                ]
            );
        }
        return response()->json($res, 200, [], JSON_NUMERIC_CHECK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd('store');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd('show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $softDeletes = [ 'created_at', 'updated_at', 'deleted_at'];
        $autosave = $this->resource->getModel()
            ->find($id)
            ->autosaves()
            ->where('autosavable_id', $id)
            ->first();

        $autosaveData = unserialize($autosave['values']);

        $originalData = $this->resource->findById($id)
            ->toArray();

        foreach ($softDeletes as $value) {
            unset($originalData[$value]);
        }

        foreach ($originalData as $key => $value) {
            $asData[$key] = $autosaveData[$key];
        }

        $link = route($this->module->getName().'.edit', $originalData['id']);

        $this->data['timestamp'] = date("Y/m/d h:i:s A", strtotime($autosave['updated_at']));
        $this->data['autosave'] = $asData;
        $this->data['original'] = $originalData;
        $this->data['originalRedirect'] = $link;
        $this->data['autosaveRedirect'] = $link.'?autosave='.$autosave['id'];

        return template('autosave', $this->data, $this->module->getName());
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
        $res['status'] = 'not in config';
        if (in_array($this->module->getName(), config('autosave'))) {
            $this->authorize('update', $this->resource->getModel());
            $this->resource->getModel()->find($id)->autosaves()->updateOrCreate(
                ['autosavable_id' => $id],
                [
                    'values' => serialize($request->all()),
                    'user_id' => auth()->user()->id
                ]
            );
            $res['status'] = 'saved';
        }
        return response()->json($res, 200, [], JSON_NUMERIC_CHECK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Check if module can lock autosaved content
        $autosave = $this->resource->getModel()
            ->find($id)
            ->autosaves()
            ->where('autosavable_id', $id)
            ->first();
        
        if($autosave){        
            $this->resource->getModel()
                ->find($id)
                ->autosaves()
                ->forceDelete();
        }
    }
}
