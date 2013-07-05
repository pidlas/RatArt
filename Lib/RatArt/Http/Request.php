<?php

namespace RatArt\Http;

/**
 * Represente la requete Http effectuée par le navigateur du client
 * @package RatArt.Http
 */
class Request {


    /**
     * C'est toutes le données postées
     *
     * @var array
     */

    public $query = array();

    function __construct() {

    }

    /**
     * Créer ou remplace un ou plusieurs ent-têtes serveur
     *
     * @param string|array L'en-tête à modifier
     */
    public function setHeader($header)
    {
        if (is_array($header)) {

            foreach ($variable as $key) {
                header($key);
            }

        } else {
            header($header);
        }
    }
    /**
     * Récupere le chemin de l'url sans l'hote HTTP
     *
     * @return string Le l'url
     */
    public function requestURI()
    {
        $uri = '';
        if (isset($_SERVER['PATH_INFO'])) {
            $uri = $_SERVER['PATH_INFO'];
        }else{
            $uri = str_replace($_SERVER['SCRIPT_NAME'], '',$_SERVER['PHP_SELF']);
        }
        if ($uri === '') {
            $uri = '/';
        } else {
            $uri = str_replace('\\', '/', $uri);
        }

        return $uri;
    }

    /**
     * Recupere la racine de l'url
     *
     * @return string La racine
     */
    public function getRoot()
    {
        return str_replace('\\', '/', dirname(dirname(dirname($_SERVER['SCRIPT_NAME']))));
    }

}
