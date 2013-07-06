<?php

namespace App\Bundle\Pages;

use RatArt\Bundle\AppController;
use RatArt\Http\Response;

/**
*
*/
class Controller extends AppController
{

    protected $Helpers = array('Html');

    public function homeAction()
    {
    }

    public function helloAction($name = null)
    {
        $this->set('name',$name);
     }
    public function showAction($slug,$id)
    {

    }
}
