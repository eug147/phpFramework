<?php


namespace wfm;


abstract class Controller
{

//    public array $data = [];
//    public array $meta = [];
//    public false|string $layout = '';
//    public string $view = '';
//    public object $model;

    public  $data = [];
    public  $meta = [];
    public  $layout = '';
    public  $view = '';
    public  $model;
    public  $route = [];


    public function __construct( $route = [] )
    {
        $this->route['controller'] = $route['controller'];
        $this->route['action'] = $route['action'];
        $this->route['slug'] = $route['slug'] ?? '';
        $this->route['admin_prefix'] = $route['admin_prefix'];

    }

    public function getModel()
    {
        $model = 'app\models\\' . $this->route['admin_prefix'] . $this->route['controller'];
        if (class_exists($model)) {
            $this->model = new $model();
        }
    }

    public function getView()
    {
        $this->view = $this->view ?: $this->route['action'];
        (new View($this->route, $this->layout, $this->view, $this->meta))->render($this->data);
    }

    public function set($data)
    {
        $this->data = $data;
    }

    public function setMeta($title = '', $description = '', $keywords = '')
    {
       $this->meta = [
           'title' => $title,
           'description' => $description,
           'keywords' => $keywords,
       ];
    }

}