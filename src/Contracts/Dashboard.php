<?php

namespace Vellum\Contracts;


interface DashboardInterface {

    /**
     * Retrieve all models fields/columns
     *
     * @return array
     */
    public function getColumns();

    
    /**
     * Display all data corresponding to the selected fields.
     * 
     * @return array
     */
    public function getData();

}