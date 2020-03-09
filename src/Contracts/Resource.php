<?php

namespace Vellum\Contracts;


interface Resource
{

    /**
     * Get selected column names from the model.
     *
     * @return array
     */
    // public function getColumnNames();

    /**
     * Get the data from the model
     *
     * @return Collection
     */
    public function getRowsData();


    public function getAttributes();


    public function getActions();


    public function getModalActions();


    public function getFilterFields();


    public function getExcludedFields();
}
