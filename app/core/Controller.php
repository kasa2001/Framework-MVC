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
     * Method add element to view
     * @param $name string - file name
     * @param $directory string - directory in folder elements (default - default)
     * */
    public function importElement($name, $directory = "default")
    {
        require_once "../app/view/elements/" . $directory . "/" . $name . ".php";
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
            echo '<script src="' . $address . 'js/jquery-3.2.1.min.js" type="text/JavaScript"></script>';
            echo '<script src="' . $address . 'js/ajaxController.js" type="text/JavaScript"></script>';
            for ($i = 0; $i < (count($table)); $i++)
                echo '<script src="' . $address . 'js/' . $table[$i] . 'Controller.js" type="text/JavaScript"></script>';
        }
    }

    public function address()
    {
        return "/".$this->config["system"]["default-directory"]."/public/";
    }

    /**
     * Method load title page
     * */
    public function loadTitle()
    {
        echo "<title>" . $this->config["system"]["default-title"] . "</title>";
    }

    public function loadCharset()
    {
        echo "<meta charset='" . $this->config["system"]["charset"] . "'>";
    }

    public function loadLanguage()
    {
        echo "lang='" . $this->config["system"]["default-language"] . "'";
    }

    /**
     * Method create element a in view
     * @param name - string
     * @param data - string
     * @param class - array string
     * */
    public function buildLink($name, $data, $class = null)
    {
        echo "<a href='" . $this->baseLink() . $data . "'";
        if (count($class) == 0) echo ">" . $name . "</a>";
        else {
            echo "class='";
            for ($i = 0; $i < count($class); $i++) {
                echo $class[$i] . " ";
            }
            echo "'>" . $name . "</a>";
        }
    }


    public function baseLink()
    {
        $address = explode("/", $_SERVER["REQUEST_URI"]);
        $data = "/";
        for ($i = 1; $i < (count($address) - 2); $i++) $data .= $address[$i] . "/";
        return $data;
    }

    /**
     * Methods create form
     * @param $action string - link to another page
     * */
    public function startForm($action = null)
    {
        echo "<form method='post'";
        if ($action == null) echo ">";
        else echo " action='" . $this->baseLink() . $action . "'>";
    }

    public function endForm()
    {
        echo "</form>";
    }
}