<?php

namespace RatArt\Routing;
use RatArt\Routing\Route;
use RatArt\Http\Request;
use RatArt\Bundle\AppController;
use RatArt\Utils\Configure;

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
    private static  $routes = array();
    /**
     * @var RatArt\Bundle\AppController Le Controller Basique
     * @access private
     */
    private $Controller;

    private $Request ;

    function __construct() {
        $this->Controller = new AppController();
        $this->Request = new Request();

    }

    /**
     * Ajoute une route aux routes existantes
     * @param Route $route L'objet Route contenant toutes les informations
     */
    public function addRoute(Route $route)
    {
        if (!in_array($route, self::$routes)) {
            self::$routes[] = $route;
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
        foreach (self::$routes as $route) {
            //Si l'URL correspond
            if ( $route->match($url) !== false) {
                if ($route->hasVars()) {

                    $varsName = $route->getVarsName();
                    $listVars = array();

                    $varsValues = $route->match($url);
                   // Si l'url ne correspond pas à la route avec des paramètres optionnel
                   if ($url !== $route->getNullUrl()) {
                       foreach ($varsValues as $key => $value) {

                        if ($key !== 0) {
                            $listVars[$varsName[$key - 1]] = $value;
                        }
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
            $this->Controller->notFound($e->getmessage());
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

    /**
     * Créer une url correspondant à une route décrite
     *
     * @param array $params Les composants requis pour identifier la route et la parser correctement.
     * @param boolean $relative Le chemin est-il relatif ?
     */
    public function createUrl(array $params)
    {
      $name = $params['name'];
      $url = '';
      //Pour chaque route
      foreach (self::$routes as $route) {
        //On trouve celle qui convient
        if ($route->Name === $name) {
            if (isset($params['params'])) {
                $vars = $route->getVarsName();
                $urlParams=explode(',',$params['params']);
                // pour savoir combien de parametres à la route
                preg_match_all("/\([^)]+\)/", $route->getUrl(),$matches);
                foreach ($matches[0] as $key => $value) {
                    //et les remplace par leur valeur dans l'url
                    $url = str_replace($value, $urlParams[$key], $route->getUrl());
                }
            }else{
                $url = $route->getUrl();
            }
          if (Configure::read('App.Routes.ExtensionIfNull') !== false && $url !== '\/' ) {
              if ($route->hasExtension() !== false && strpos($url,'.'.$route->hasExtension() === false)) {
                      $url = $url. '.'.$route->hasExtension();
                  } elseif (Configure::read('App.Routes.HasExtension') === true and Configure::read('App.Routes.Extension') !== '' && strpos($url,'.'.$route->hasExtension() === false)) {
                      $url = $url. '.'.Configure::read('App.Routes.Extension');
                  }
          }
        }
      }
      $url = str_replace('\/', '/', $url);
      $url = str_replace('\.', '.', $url);
      return str_replace('//', '/', $this->Request->getRoot().$url);

    }

}
