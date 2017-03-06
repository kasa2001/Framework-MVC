<?php


class Controller
{
    /**
     * Function where add model and connect whit database if exists $_POST
     * @param $model - how model
     * @return model (return new model from view)
     * */
    public function model($model)
    {
        require_once '../app/models/table/' . $model . 'Table.php';
        return new $model();
    }

    /**
     * Function which load layout
     * @param $view - add this view
     * @param $data - current information
     * @param $css (table where is save all CSS from view)
     * @param $js (table where is save all JavaScript from view)
     * */
    public function view($view, $data = [], $css, $js)
    {
        require_once '../app/views/layout/layout.php';
    }

    /**
     * Function which load current view
     * @param $view (load this view)
     * @param $data (data for current view)
     * */

    public function content($view, $data = [])
    {
        require_once '../app/views/' . $view . '.php';
    }

    /**
     * Function which add CSS
     * @param $css (table where is save all CSS from view)
     */
    public function loadCss($css)
    {
        if ($css != "") {
            $table = explode(' ', $css);
            $address = $this->address();
            for ($i = 0; $i < (count($table)); $i++) {
                echo '<link href="' . $address . 'css/' . $table[$i] . '.css" rel="stylesheet" type="text/css">';
            }
        }
    }

    /**
     * Function which add JavaScript
     * @param $js (table where is save all JavaScript from view)
     */
    public function loadJs($js)
    {
        if ($js != "") {
            $table = explode(' ', $js);
            $address = $this->address();
            for ($i = 0; $i < (count($table)); $i++) {
                echo '<script src="' . $address . 'js/' . $table[$i] . 'Controller.js" type="text/JavaScript"></script>';
            }
        }
    }

    public function address(){
        $how = count(explode('/', $_SERVER['REQUEST_URI']));
        $address = NULL;
        if ($how > 4) {
            for ($j = 0; $j < ($how - 4); $j++) {
                $add = "../";
                $address = $address . $add;
            }
        }
        return $address;
    }
}