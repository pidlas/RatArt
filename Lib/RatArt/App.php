<?php

namespace RatArt;

use RatArt\Utils\Configure;
use RatArt\Routing\Router;
use RatArt\Utils\Debug;

/**
*  C'est le point d'entrée de l'application
* @package RatArt
*/
class App
{

    /**
     * @var array Les configurations par défaut
     */
    private $_configs = array(
            'Mode' => 'dev',
            'Cache' => array('Time' => 32000,'Path' => 'Web/tmp'),
            'Route' => array('HasExtension' => false));

    function __construct($config = null)
    {
        require_once ROOT.DS."Lib".DS."RatArt".DS."Bootstrap.php";
        if(isset($config)){
            $this->_configs = array_merge($this->_configs,$config);
        }
        Configure::write('App',$this->_configs);

        $Router = new Router();
        $Router->dispatch();
        Debug::timer();


    }



}
