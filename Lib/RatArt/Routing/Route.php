<?php

namespace RatArt\Routing;
/**
* C'est le lien entre une URL tapée et les routes qui sont donnée dans chaque Bundle
*/
class Route
{
    /**
     * @var array Les expressions régulières
     * @access private
     */
    static private  $regexs = array(
        '(:num)' =>"([0-9\-]+)",
        '(:alpha)' => "([a-z\-]+)",

    );

    /**
     * @var string Le nom du Bundle
     */
    protected $Bundle;
    protected $Name ;
    protected $field;
    protected $action;
    protected $varsName;
    protected $vars = array();

    function __construct($Bundle,$Name,array $field,array $varsName)
    {
       $this->setBundle($Bundle);
       $this->setName($Name);
       $this->setField($field);
       $this->setUrl($this->useRegex($this->field['url']));
       $this->setAction($this->field['action']);
       $this->setVarsName($varsName);
    }

    public function useRegex($url)
    {
        $rules = self::$regexs;
        foreach ($rules as $rule => $regex) {
            $url = str_replace($rule,$regex, $url);
        }
        $url = str_replace('/', '\/', $url);
        return $url;
    }
    public function match($url)
    {
        if (preg_match('`^'.$this->field['url'].'$`', $url,$matches)) {
            return $matches;
        } else {
            return false;
        }
    }

    public function hasVars()
    {
        return !empty($this->varsName);
    }

    public function getBundle()
    {
        return $this->Bundle;
    }
    public function setBundle($Bundle)
    {
       $this->Bundle = $Bundle;
    }
    public function getName()
    {
        return $this->Name;
    }

    public function setName($Name)
    {
        $this->Name = $Name;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setAction($action)
    {
        $this->action = $action.'Action';
    }

    public function getUrl()
    {
        return $this->field['url'];
    }

    public function setUrl($url)
    {
        $this->field['url'] = $url;
    }

    public function getField()
    {
        return $this->field;
    }

    public function setField(array $field)
    {
        $this->field = $field;
    }

    public function getVarsName()
    {
        return $this->varsName;
    }

    public function setVarsName(array $varsName)
    {
        $this->varsName = $varsName;
    }

    public function getVars()
    {
        if (is_null($this->vars) && !is_array($this->vars)) {
            return array();
        } else {
            return $this->vars;
        }

    }
    public function setVars(array $vars)
    {
        $this->vars = $vars;
    }

}
