<?php

namespace RatArt\Bundle;

use RatArt\Debug\Debug ;
use RatArt\Http\Response ;

/**
* Le Controller principal
* @package RatArt.Bundle
*/
class AppController
{
    /**
     * @var array Les variables destinées à la vue
     * @access private
     */
    private static $variables = array();

    /**
     * @var RatArt\Http\Response La réponse Http
     */
    protected $Response ;

    /**
     * @var string Le nom du layout utilisé ( le fichier se trouvant dans le dossier App/Template )
     */
    protected $layout = 'base';
    /**
     * Le Constructeur
     *
     */
    function __construct()
    {
        Debug::timer();
        $this->Response = new Response();
    }

    /**
     * Permet de rendre une vue
     *
     * @param string $file Le nom du fichier à rendre
     * @param array|null $vars Les variables pour la vue. Nulle si l'auto rendu est activé et les variables doivent être "settée" par $this->set().
     */
    public function render($file,$vars = null)
    {
        Debug::timer();
        $view = str_replace('.php', '', str_replace('@', ROOT.DS.'App'.DS, $file)).'.php';

        if (!is_null($vars)) {
            extract($vars);

            // Multiples utilisation du buffer
                ob_start();
                require_once $view;

                $content_for_layout = ob_get_clean();
                ob_start();
                require_once 'App/Template/'.$this->layout.'.php';
                $html = ob_get_clean();
                $this->Response->setContent($html);
                $this->Response->send();
                Debug::timer();
        }else{
            $this->render($view,self::$variables);
        }
    }

    /**
     * Permet de donner à la vue des variables
     *
     * @param string|array Le nom de la variable ou un tableau contenant plusieurs variables
     * @param mixed|null La valeur de la variable ou rien si $key est un tableau
     */
    public function set($key,$value = null)
    {
        if (is_array($key)) {
            self::$variables += $key;
        } else {
            self::$variables[$key] = $value;
        }
    }

    /**
     * Indique au visiteur que la page n'a pu etre trouvée
     */
    public function notFound($message)
    {
        $this->Response->setCode(404);
        $this->render('@Template/error.php',array(
            'message'=> $message
        ));
    }
}
