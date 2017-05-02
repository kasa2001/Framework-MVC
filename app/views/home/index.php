<?php
$var["ala"] = "Zmienna";
$this->session->writeToSession($var);
echo $this->session->getDataWithSession("ala");