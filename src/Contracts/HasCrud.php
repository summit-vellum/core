<?php

namespace Vellum\Contracts;

/**
 *  Perform Created, Read, Update and Delete execution to
 *  a given class.
 */
interface HasCrud
{
    /**
     * Find a resource based on primary id
     * 
     * @param  int    $id Resource id
     * @return Eloquent     
     */
    public function findById(int $id);

    /**
     * Create new resource or update resource based on specified 
     * resource primary id.
     * 
     * @param  array       $data Request data or field value array
     * @param  int|integer $id   Resource id
     * @return Eloquent            
     */
    public function save(array $data, int $id = 0);

    /**
     * Delete a specified resource. 
     * 
     * @param  int|integer $id Resource id
     * @return bool            
     */
    public function delete(int $id = 0);

}