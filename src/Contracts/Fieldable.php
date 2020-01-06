<?php

namespace Vellum\Contracts;


interface Fieldable
{

    /**
     * Initialize property and value of the implementing class.
     *
     * @return array
     */
    public function showableFields();
}