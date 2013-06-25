<?php

namespace RatArt\Kernel\Utils;

/**
* Permet d'utiliser le DotNotaion
* @package RatArt.Kernel.Utils
*/
class Dot
{

    /**
     * Donne à une clé ( dans un tableau donné ) la valeur voulue.
     * @access public
     * @param array $namespace Le tableau ou sont stocké les valeurs
     * @param string $path Le chemin de la clé ( en Dot Notation )
     * @param mixed $values La valeur associée à la clé
     */
    public static function set(array $namespace,$path,$values)
    {
        $path = explode('.', $path);
        $_list = &$namespace;
        $count = count($path);
        $last = $count - 1;

        foreach ($path as $i => $key) {
            if (is_numeric($key) and intval($key) > 0 || $key === '0') {
                $key = intval($key);
            }
            if($i === $last){
                $_list[$key] = $values;
                return $namespace;
            }
            if (!isset($_list[$key])) {
                $_list[$key] = array();
            }
            $_list =& $_list[$key];
            if (!is_array($_list)) {
                $_list = array();
            }
        }
    }
    /**
     * Lit la valeur de la clé dans le tableau voulu
     * @param array $namespace Le tableau ou se trouvent les valeurs
     * @param string $key Le nom de la clé
     * @return mixed
     * @access public
     */
    public static function get($namespace,$key)
    {
        $path = explode('.',$key);
        if (isset($namespace[$path[0]])) {
            $data = $namespace[$path[0]];
        } else {
            return false;
        }
        if (count($path) === 1) {
            return is_scalar($data)?$data:(object)$data;
        }else{

            $path = array_slice($path,1);
            $counter = count($path);
            for ($i=0; $i < $counter; $i++) {

                $data = $data[$path[$i]];
            }
            return is_scalar($data)?$data:(object)$data;
        }
    }

    /**
     * Supprime la clé demandée dans le tableau
     * @param array $namespace Le tableau ou se trouvent les valeurs
     * @param string $key Le nom de la clé
     * @access public
     */
    public static function remove(array $namespace,$path)
    {
        // c'est très similaire à la function set
        $path = explode('.', $path);
        $_list = &$namespace;
        $count = count($path);
        $last = $count - 1;
        foreach ($path as $i => $key) {
            if (is_numeric($key) and intval($key) > 0 || $key === '0') {
                $key = intval($key);
            }
            if($i === $last){
                unset($_list[$key]);
                return $namespace;
            }
            if (!isset($_list[$key])) {
                return $namespace;
            }
            $_list =& $_list[$key];
            if (!is_array($_list)) {
                $_list = array();
            }
        }
    }

}
