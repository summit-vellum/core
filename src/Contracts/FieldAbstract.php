<?php

namespace Vellum\Contracts;

use Vellum\Models\BaseModel;
use Vellum\Contracts\Fieldable;


abstract class FieldAbstract extends BaseModel implements Fieldable
{
    public function getProperties() {
        return array_keys($this->selectFields());
    }

    public function getValues(){
        return array_values($this->selectFields());
    }

    abstract public function selectFields($fields = []);
}
