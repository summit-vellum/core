<?php

namespace Vellum\Base;

use Illuminate\Foundation\Http\FormRequest;
use Vellum\Contracts\Resource;

class BaseFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Resource $resource)
    {
        $fields = $resource->getAttributes();
        
        return array_key_exists('rules', $fields) ? $fields['rules'] : [];
    }
}
