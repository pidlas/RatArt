<?php
    define('ROOT', dirname(dirname(dirname(__FILE__))));
    define('DS',DIRECTORY_SEPARATOR);
    
    require_once ROOT.DS."Lib".DS."RatArt".DS."Kernel".DS."Autoloader.php";

    $configs = json_decode(file_get_contents('App/Config/App.json'),true);
    new RatArt\Kernel\App($configs);

    $Request = new RatArt\Kernel\Http\Request();
    $Request->setHeader('Content-Type: text/plain');
    $Response = new RatArt\Kernel\Http\Response('Hello World !');
    $Response->send();

