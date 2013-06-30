<?php

namespace RatArt;

use RatArt\Utils\Configure;
use RatArt\Routing\Router;


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
            'Mode' => 'dev'
        );

    function __construct($config = null)
    {
        if(isset($config)){
            $this->_configs = $config;
        }
        Configure::write('App',$this->_configs);
        $Router = new Router();
        $Router->dispatch();
    }



}
