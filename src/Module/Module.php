<?php

namespace Vellum\Module;


class Module
{

    protected $name;

    protected $title;

    protected $path;

    protected $model;



    public function __construct($properties)
    {
        foreach ($properties as $key => $value) {
        	$this->$key = $value;
        }
    }

    public function setName($value)
    {
        $this->name = $value;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setTitle($value)
    {
        $this->title = $value;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setPath($value)
    {
        $this->path = $value;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setModel($value)
    {
        $this->model = $value;
    }

    public function getModel()
    {
        return $this->model;
    }

}
