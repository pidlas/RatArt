<?php

use RatArt\Debug\Debug;
use RatArt\Utils\Configure;
Debug::timer();


    function debug(){
        if (Configure::read('App.Mode') == 'dev') {
            $arguments = func_get_args();
            $debug = debug_backtrace();

            foreach ($debug as $files => $value) {
                if (isset( $debug[$files]['file'])) {
                    $debug[$files]['file'] = str_replace('\\', '/', str_replace('@'.DS, '@', str_replace(ROOT, '@', $value['file']))) ;
                }
            }
            Debug::log($arguments,$debug);
        }
    };
?>
