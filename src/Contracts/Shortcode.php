<?php

namespace Vellum\Contracts;

use Illuminate\Support\Collection;


interface Shortcode 
{
    public function parameters();
    
    public function input(Collection $collection);

    public function code();

    public function settings();
}
