<?php

namespace RatArt\Kernel\Http;

/**
 * Represente la requete Http effectuée par le navigateur du client
 * @package RatArt.Kernel.Http
 */
class Request implements \ArrayAccess{


    /**
     * C'est toutes le données postées
     * @var array
     */

    public $query = array();

    function __construct() {

    }

    /**
     * Créer ou remplace un ou plusieurs ent-têtes serveur
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

}
