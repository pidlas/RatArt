<?php
namespace RatArt\Debug;

use RatArt\Utils\Configure;
/**
*
*/
class Debug
{
    static $times = array();

    static function timer($name = 'kernel.request')
    {
        $time = microtime(true);
        self::$times[$name][] = $time;

    }

    static function log(array $variables, $files = null)
    {
        foreach ($variables as $key => $value) {
           if (function_exists('xdebug_break')) {
                echo "<div class='ratart-debug'>";
                    var_dump($value);
                echo "</div>";
           } else {
                echo "<div class='ratart-debug'>";
                echo "<pre>";
                    print_r($value);
                echo "</pre>";
                echo "</div>";
           }

        }
    }

}
