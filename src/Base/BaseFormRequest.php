<?php

namespace Vellum\Base;

use Illuminate\Foundation\Http\FormRequest;
use Vellum\Contracts\Resource;

class BaseFormRequest extends FormRequest
{
    private $messages = [];

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

        array_key_exists('messages', $fields) ? $this->setMessages($fields) : '';

        return array_key_exists('rules', $fields) ? $this->methodValidations($fields) : [];
    }

    public function messages()
    {
        return $this->messages;
    }

    private function methodValidations($fields)
    {
        if (request()->isMethod('put')) {
            $methodKeys = 'updateRules';
        } else if (request()->isMethod('post')) {
            $methodKeys = 'createRules';
        }

        $mergedRules = [];
        
        foreach ($fields['rules'] as $key => $value) {
            $collect = array_key_exists($methodKeys, $fields) ?  $fields[$methodKeys] : [];
            if (collect($collect)->has($key)) {
                $mergedRules[$key] = $value . '|' . collect($collect)->get($key);
            } else {
                $mergedRules[$key] = $value;
            }
        } 

        return $mergedRules;
    }

    private function setMessages($fields)
    {
        collect($fields['messages'])->each(function ($rules, $name) {
            collect($rules)->each(function ($value, $key) use ($name) {
                $this->messages[$name . '.' . $key] = $value;
            });
        });
    }
}
