<?php

class Controller
{
    protected $data;

    protected $model;

    protected $params;

    protected $view_path;

    protected $no_layout;

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    public function useLayout()
    {
        return (isset($this->no_layout) && ($this->no_layout != null)) ? false : true;
    }

    public function setNoLayout($value = true)
    {
        $this->no_layout = $value;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    public function __construct($data = [])
    {
        $this->data = $data;
        $this->params = App::getRouter()->getParams();
        
    }
}