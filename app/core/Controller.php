<?php


class Controller extends Config
{
    /**
     * Method where add model and connect whit database if exists $_POST
     * @param $model - how model
     * @return object. Return new model from view
     * */
    public function loadModel($model)
    {
        $model .= "Table";
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    /**
     * Method which load layout
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
     * Method which load current view
     * @param $view (load this view)
     * @param $data (data for current view)
     * */

    public function content($view, $data = [])
    {
        require_once '../app/views/' . $view . '.php';
    }

    /**
     * Method which add CSS
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
     * Method which add JavaScript
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

    public function address()
    {
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

    /**
     * Method load title page
     * */
    public function loadTitle(){
        echo "<title>".$this->config["system"]["default-title"]."</title>";
    }

    public function loadCharset(){
        echo "<meta charset='".$this->config["system"]["charset"]."'>";
    }
}