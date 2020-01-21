<?php

namespace Vellum\Contracts;

use Illuminate\Support\Collection;

interface Shortcode
{
    public function parameters();

    public function input($collection);

    public function code();
}
