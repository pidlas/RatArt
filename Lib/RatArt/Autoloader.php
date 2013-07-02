<?php

    chdir(ROOT);
    $vendor_autoloader = ROOT.DS."vendor".DS."autoload.php";
    require_once $vendor_autoloader;

    function autoload($class)
    {
        $file = str_replace('\\', DS, $class).".php";

        if (strpos($file,'RatArt') === 0) {
            require_once ROOT.DS.'Lib'.DS.$file;
        } else {
            require_once $file;
        }

    }

    spl_autoload_register('autoload');
    require_once dirname(__FILE__).DS.'Bootstrap.php';


 ?>
