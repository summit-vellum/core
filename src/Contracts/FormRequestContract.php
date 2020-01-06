<?php

namespace Vellum\Contracts;

use Vellum\Contracts\Resource;

interface FormRequestContract
{

    public function rules(Resource $resource);
}