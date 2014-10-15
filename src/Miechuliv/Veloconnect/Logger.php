<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 14.10.14
 * Time: 15:02
 */

namespace Miechuliv\Veloconnect;
use Miechuliv\Veloconnect;


class Logger {

    static public function log($msg)
    {
        if(Veloconnect\Config::$LOG_ERRORS)
        {
            $functionName = Veloconnect\Config::$LOGGING_FUNCTION;
            Veloconnect\Config::$LOGGING_OBJECT->$functionName($msg);
        }

        if(Veloconnect\Config::$DISPLAY_ERRORS)
        {
            echo $msg;
        }
    }

} 