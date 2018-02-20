<?php
    // setup locale and translation
    setlocale(LC_ALL, $locale);
    require_once "lang/$language.php";

    function T($str)
    {
        global $L;
        if (isset($L[$str]))
            return $L[$str];
        else
            return $str;
    }

    function mb_ucfirst($string, $encoding = 'UTF-8')
    {
        $strlen = mb_strlen($string, $encoding);
        $firstChar = mb_substr($string, 0, 1, $encoding);
        $then = mb_substr($string, 1, $strlen - 1, $encoding);
        return mb_strtoupper($firstChar, $encoding) . $then;
    }
?>
