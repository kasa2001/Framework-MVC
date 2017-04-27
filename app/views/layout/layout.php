<!doctype html>
<html <?php $this->loadLanguage()?>>
    <head>
        <?php
            $this->loadTitle();
            $this->loadCharset();
            $this->loadCss($css);
        ?>
    </head>
    <body>
        <?php
            $this->content($view,$data);
            $this->loadJs($js);
        ?>
    </body>
</html>