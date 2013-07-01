<?php

namespace RatArt\Routing;
/**
* Répresente une route qui sera uitlisé pour le Routing
* @package RatArt.Routing
*/
class Route
{
    /**
     * @var array Les expressions régulières facilitent la configuration des routes mais elles ne sont pas obligatoires
     *
     * @access private
     */
    static private  $regexs = array(
        '(:num)' =>"([0-9\-]+)",
        '(:alpha)' => "([a-z-A-Z\-]+)",

    );

    /**
     * @var string Le nom du Bundle
     * @access protected
     */
    protected $Bundle;
    /**
     * @var string Le nom de la route
     * @access protected
     */
    protected $Name ;
    /**
     * @var array Les champs de configurations ( contient l'url, l'action et les variables )
     * @access protected
     */
    protected $field;
    /**
     * @var string L'action ( qui est contenu dans $field )
     * @access protected
     */
    protected $action;
    /**
     * @var array Le nom des variables
     * @access protected
     */
    protected $varsName;
    /**
     * @var array Toutes les variables contenues dans l'url
     * @access protected
     */
    protected $vars = array();

    /**
     * Le constructeur d'une route ( c'est ce qui la définie comme telle )
     *
     * @param string $Bundle Le nom du bundle auquel elle apppartient
     * @param string $Name Chaques routes à un nom
     * @param array $field Chaques routes à un champ qui définie sa configuration ( l'url,l'action,les variables )
     * @param array $varsName Les noms des variables
     */
    function __construct($Bundle,$Name,array $field,array $varsName)
    {
       $this->setBundle($Bundle);
       $this->setName($Name);
       $this->setField($field);
       $this->setUrl($this->useRegex($this->field['url']));
       $this->setAction($this->field['action']);
       $this->setVarsName($varsName);
       $this->setAutoRender(isset($this->field['auto-render'])?true:false);
    }

    /**
     * Permet le filtrage des expressions régulières
     *
     * @param string L'url non-filtrée
     * @return string L'url filtrée
     */
    private function useRegex($url)
    {
        $rules = self::$regexs;
        foreach ($rules as $rule => $regex) {
            $url = str_replace($rule,$regex, $url);
        }
        $url = str_replace('/', '\/', $url);
        return $url;
    }
    /**
     * L'url correspond elle avec l'url de la route actuelle
     *
     * @param string $url L'url censée "matcher"
     */
    public function match($url)
    {
        if (preg_match('`^'.$this->field['url'].'$`', $url,$matches)) {
            return $matches;
        } else {
            return false;
        }
    }
    /**
     * Dit si la route à des variables
     *
     * @return boolean Confirme si la route à des variables
     */
    public function hasVars()
    {
        return !empty($this->varsName);
    }
    /**
     * Donne le du Bundle dans lequel est contenu l'url
     *
     * @return string Le nom du Bundle
     */
    public function getBundle()
    {
        return $this->Bundle;
    }
    /**
     * Change le nom du Bundle
     *
     * @param string Le nouveau nom du Bundle
     */
    public function setBundle($Bundle)
    {
       $this->Bundle = $Bundle;
    }
    /**
     * Retourne le nom de la route
     *
     * @return string Le nom de la route
     */
    public function getName()
    {
        return $this->Name;
    }
    /**
     * Remplace le nom de la route
     *
     * @param string $Name Le nouveau nom de la route
     */
    public function setName($Name)
    {
        $this->Name = $Name;
    }

    /**
     * Retourne l'action de la route
     *
     * @return string L'action de la route
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Change le nom de l'action
     *
     * @param string $action Le nom de la action ( foramtée telle que fooAction )
     */
    public function setAction($action)
    {
        $this->action = $action.'Action';
    }
    /**
     * Retourne L'url de la route
     *
     * @return string L'url de la route
     */
    public function getUrl()
    {
        return $this->field['url'];
    }
    /**
     * Change l'url de la route
     *
     * @param string $url La nouvelle url
     */
    public function setUrl($url)
    {
        $this->field['url'] = $url;
    }
    /**
     * Retourne le champ des configurations de la route
     *
     * @return array Les configurations de la route
     */
    public function getField()
    {
        return $this->field;
    }
    /**
     * Remplace les configurations de la route
     *
     * @param array $field Les nouvelles configurations de la route
     */
    public function setField(array $field)
    {
        $this->field = $field;
    }
    /**
     * Retourne le nom des variables
     *
     * @return array Le noms des varaibles
     */
    public function getVarsName()
    {
        return $this->varsName;
    }
    /**
     * Change le nom des variables
     *
     * @param arary $varsName Les nouveaux des variables
     */
    public function setVarsName(array $varsName)
    {
        $this->varsName = $varsName;
    }
    /**
     * Retourne les variables contenues dans la route
     *
     * @return array Les variables contenues dans la route
     */
    public function getVars()
    {
        if (is_null($this->vars) && !is_array($this->vars)) {
            return array();
        } else {
            return $this->vars;
        }

    }
    /**
     * Change les variables contenues dans la route
     *
     * @param array Les nouvelles variables
     */
    public function setVars(array $vars)
    {
        $this->vars = $vars;
    }
    /**
     * Permet de changer l'auto-rendu
     *
     * @param boolean $autoRender La valeur de l'auto rendu
     */
    public function setAutoRender($autoRender)
    {
        $this->field['auto-render'] = $autoRender;
    }
    /**
     * Retourne la valeur de l'auto rendu
     *
     * @return boolean La valeur de l'auto rendu
     */
    public function getAutoRender()
    {
        return $this->field['auto-render'];
    }

}
