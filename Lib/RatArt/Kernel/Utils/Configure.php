<?php

namespace RatArt\Kernel\Utils;

use RatArt\Kernel\Utils\Dot;

/**
 * Cette classe permet de dialoguer avec une configuration donnée.
* <italic>Cette classe utilise le Dot Notation </italic>
*
* @package RatArt.Kernel.Utils
*/
class Configure
{

    public static $_data = array();

    /**
     * Donne à la clé la valeur souhaitée.
     * @param string $key Le chemin de la clé ( en Dot Notation )
     * @param mixed $value La valeur associée à la clé
     * @example Configure::write('App.Database.Blog') ercit la valeur des données "database" dans $this->_data
     * @access public
     */
    public static function write($key,$value)
    {
        return (self::$_data = Dot::set(self::$_data,$key,$value));
    }


    /**
     * Lit la valeur de la clé dans les configurations
     * @param string $key Le nom de la clé
     * @return mixed
     * @access public
     * @example Configure::read('database.blog') retourne la valeur du tableau correspondant dans $this->_data sous forme de tableau si possible
     */
    public static function read($key = null)
    {
        if (is_null($key)) {
            return self::$_data;
        } else {
            return Dot::get(self::$_data,$key);
        }


    }


}
