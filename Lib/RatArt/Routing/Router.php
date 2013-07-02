<?php

namespace RatArt\Routing;
use RatArt\Routing\Route;
use RatArt\Http\Request;
use RatArt\Bundle\AppController;
/**
 * Le router permet de lier une URL à un Bundle spécifique et à une action
 * @package RatArt.Routing
 */
class Router
{
    /**
     * @var array Toutes les routes sont stockées ici
     * @access private
     */
    private  $routes = array();
    /**
     * @var RatArt\Bundle\AppController Le Controller Basique
     * @access private
     */
    private $Controller;

    function __construct() {
        $this->Controller = new AppController();
    }

    /**
     * Ajoute une route aux routes existantes
     * @param Route $route L'objet Route contenant toutes les informations
     */
    public function addRoute(Route $route)
    {
        if (!in_array($route, $this->routes)) {
            $this->routes[] = $route;
        }

    }

    /**
     * Trouve une route qui correspond à une URL
     *
     * @param string $url L'Url qui doit correspondre à une route
     * @return RatArt\Routing\Route Une instance de la route trouvée
     */
    public function getRoute($url)
    {
        //On parcourt toutes les routes
        foreach ($this->routes as $route) {
            //Si l'URL correspond
            if ( $route->match($url) !== false) {
                $varsValues = $route->match($url);
                if ($route->hasVars()) {

                    $varsName = $route->getVarsName();
                    $listVars = array();

                    foreach ($varsValues as $key => $value) {

                      if ($key !== 0) {
                          $listVars[$varsName[$key - 1]] = $value;
                      }
                    }
                    $route->setVars($listVars);
                }
                return $route;
            }

        }
        $this->Controller->notFound('404 Not Found');
    }

    /**
     * Récupere toutes les routes qui sont dans tout les Bundles de l'Application
     * ( le fichier routes.json).
     * @return array Un tableau qui contient toutes les routes
     */
    public function allRoutes()
    {
        $routesConfig = json_decode(file_get_contents('App/Config/Bundles.json'),true);
        $routes = array();
        foreach ($routesConfig  as $bundle) {
            $file = 'App/Bundle/'.$bundle.'/routes.json';
             if (file_exists($file)) {
                $json = json_decode(file_get_contents($file),true);
                    $routes [$bundle]= $json;
            }
        }
        return $routes;
    }

    /**
     * Renvoi le controller courant
     * @return Object Le controller
     */
    public function dispatch()
    {
        $routes = $this->allRoutes();
        $Request = new Request();
        // Pour chaque Bundle
        foreach ($routes as $route => $options) {
            $vars = array();
            // On cherche les champs

            foreach ($options as $field) {
                if (isset($field['vars']) && $field['vars'] != '') {
                    $vars = explode(',', $field['vars']);
                }
                $this->addRoute(new Route($route,current(array_keys($options)),$field,$vars));
                array_shift($options);
            }
        }
        try {
            $matchedRoute = $this->getRoute($Request->requestURI());
        } catch (\RuntimeException $e) {
            die($e->getmessage());
        }

        $classController = 'App\\Bundle\\'.$matchedRoute->getBundle().'\\Controller';
        $parentController = get_parent_class($classController);
        if (!in_array($matchedRoute->getAction(), array_diff(get_class_methods($classController),get_class_methods($parentController)))) {
            $this->Controller->notFound('404 not found');

        } else {
            // Equivalent de call_user_func_array pour les namespaces
            $reflection = new \ReflectionMethod($classController,$matchedRoute->getAction());
            $reflection->invokeArgs(new $classController(),$matchedRoute->getvars());

            // Auto rendu
            if ($matchedRoute->getAutoRender()) {
                // On instancie le controller
                $classController = new $classController();
                $classController->render('@Bundle'.DS.$matchedRoute->getBundle().DS."View".DS.$matchedRoute->getAction());
            }

        }


    }

}
