<?php


namespace wfm;


class View
{

    public  $content = '';
    public $route;
    public $layout = '';
    public $view = '';
    public $meta = [];
    public $isMainMenu = true;
    public $isOrderSp = false;

    public function __construct(
         $route,
         $layout ,
         $view ,
         $meta
    )
    {
// init
        $this->route['controller'] = $route['controller'];
        $this->route['action'] = $route['action'];
        $this->route['admin_prefix'] = $route['admin_prefix'];

        $this->layout = $layout;
        $this->view = $view;

        $this->meta['title'] = $meta['title'];
        $this->meta['description'] = $meta['description'];
        $this->meta['keywords'] = $meta['keywords'];

        if (false !== $this->layout) {
            $this->layout = $this->layout ?: LAYOUT;
        }
    }

    public function render($data)
    {
        if (is_array($data)) {
            extract($data);
        }
        $prefix = str_replace('\\', '/', $this->route['admin_prefix']);
        $view_file = APP . "/views/{$prefix}{$this->route['controller']}/{$this->view}.php";
        if (is_file($view_file)) {
            ob_start();
            require_once $view_file;
            $this->content = ob_get_clean();
        } else {
            throw new \Exception("Не найден вид {$view_file}", 500);
        }

        if (false !== $this->layout) {
            $layout_file = APP . "/views/layouts/{$this->layout}.php";
            if (is_file($layout_file)) {
                require_once $layout_file;
            } else {
                throw new \Exception("Не найден шаблон {$layout_file}", 500);
            }
        }
    }

    public function getMeta()
    {
        $out = '<title>' . h($this->meta['title']) . '</title>' . PHP_EOL;
        $out .= '<meta name="description" content="' . h($this->meta['description']) . '">' . PHP_EOL;
        $out .= '<meta name="keywords" content="' . h($this->meta['keywords']) . '">' . PHP_EOL;
        return $out;
    }

    public function getPart($file, $data = null)
    {
        if (is_array($data)) {
            extract($data);
        }
        $file = APP . "/views/{$file}.php";
        if (is_file($file)) {
            require $file;
        } else {
            echo "File {$file} not found...";
        }
    }

    public  function hc($str){
        echo($str . "\n");
    }


}