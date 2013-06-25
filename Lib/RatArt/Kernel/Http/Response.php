<?php

namespace RatArt\Kernel\Http;

/**
* Représente une simple réponse Http
*/
class Response
{

    /**
     * Ce sont les en-têtes HTTP envoyé
     * @var array
     */
    protected $headers = array();

    /**
     * Tout le contenu Html retourné
     * @var string
     */
    protected $content = '';

    /**
     *
     * @param string $content Le contenu de la réponse Html
     */
    function __construct($content) {
        $this->content = $content;

    }

    /**
     * Retourne le contenu Html
     * @return string Le contenu Html
     */
    public function getContent()
    {
        return $this->content;
    }
    /**
     * Remplace le contenu de la réponse avant envoi
     * @param string $content Le contenu Html
     */
    public function setContent($content)
    {
        $this->content = $content;

    }
    /**
     * Rajoute du contenu Html avant l'envoi
     * @param string Le contenu à rajouté
     */
    public function addContent($content)
    {
        $this->content .= $content;

    }
    /**
     * Envoi la réponse Http et son contenu
     */
    public function send()
    {
        exit($this->content);
    }

    public function getHeaders()
    {
        return $this->headers;
    }

}
