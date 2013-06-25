<?php

    require_once "../../Lib/RatArt/Kernel/Autoloader.php";

    $configs = json_decode(file_get_contents('App/Config/App.json'),true);
     new RatArt\Kernel\App($configs);

     $Response = new RatArt\Kernel\Http\Response('Hello World !');
     $Response->send();

