<?php
    //so long but necessary
    chdir(dirname(dirname(dirname(dirname(__FILE__)))));

    $vendor_autoloader = dirname(dirname(dirname(dirname(__FILE__))))."/vendor/autoload.php";
    require_once $vendor_autoloader;

    function autoload($class)
    {
        $root = dirname(dirname(dirname(dirname(__FILE__))));

        $file = str_replace('\\', DIRECTORY_SEPARATOR, $class).".php";

        if (strpos($file,'RatArt') === 0) {
            require_once $root.DIRECTORY_SEPARATOR.'Lib'.DIRECTORY_SEPARATOR.$file;
        } else {
            require_once $file;
        }


    }

    spl_autoload_register('autoload');

 ?>
