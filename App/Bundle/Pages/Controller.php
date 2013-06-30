<?php

namespace App\Bundle\Pages;

use RatArt\Bundle\AppController;
use RatArt\Http\Response;

/**
*
*/
class Controller extends AppController
{

    function __construct()
    {

    }

    public function homeAction()
    {
        $Response = new Response();
        $Response->setCode(200);
        $Response->setContent(
            '<html>
            <head>
                <title>Hello</title>
            </head>
            <body>
                Hi I\'m '.__NAMESPACE__.'\Controller
            </body>
            </html>'
        );
        $Response->send();
    }
    public function showAction($slug,$id)
    {
        return new Response($slug.'-'.$id);
    }
}
