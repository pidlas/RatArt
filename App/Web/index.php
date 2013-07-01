<?php

    use RatArt\Debug\Debug;

    define('ROOT', dirname(dirname(dirname(__FILE__))));
    define('DS',DIRECTORY_SEPARATOR);

    require_once ROOT.DS."Lib".DS."RatArt".DS."Autoloader.php";

    $configs = json_decode(file_get_contents('App/Config/App.json'),true);
    new RatArt\App($configs);


    Debug::timer();
