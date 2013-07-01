<?php

namespace App\Bundle\Pages;

use RatArt\Bundle\AppController;
use RatArt\Http\Response;

/**
*
*/
class Controller extends AppController
{

    public function homeAction()
    {
        # code...
    }

    public function helloAction($name)
    {
        $this->set('name',$name);
     }
    public function showAction($slug,$id)
    {

    }
}
