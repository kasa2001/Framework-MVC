<?php


class Security
{
    /**
     * Method block SQL Injection
     * @param $data array - data from form
     * @return boolean
     * */
    public static function analyzeSQL($data)
    {
        foreach ($data as $datum) if (strpos($datum, "'")) {
            self::addLog("sql");
            return true;
        }
        return false;
    }

    /**
     * Method save data about attack on page
     * @param $attack string
     * */
    private static function addLog($attack)
    {
        $file = ("../app/logs/" . $attack . ".log");
        $FILE = fopen($file, "a");
        fwrite($FILE, "Atak z dnia: " . date("d/m/y") . " godziny: " . date("h:i:sa") . "\n");
        fclose($FILE);
    }
}