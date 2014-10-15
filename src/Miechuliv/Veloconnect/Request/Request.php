<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 14.10.14
 * Time: 09:25
 */

namespace Miechuliv\Veloconnect\Request;
use Miechuliv\Veloconnect;

class Request {

    /**
     * Wysyła zapytanie do serwera obsługującego interfejs veloconnect
     * @param $url
     * @param bool $postVars
     * @return mixed
     * @throws \Exception
     */
    public function execute($url,$postVars = false)
    {
        if(!$url || strlen($url) < 3)
        {
           $msg = 'Url is empty or too short: '.$url;
           Throw new \Exception($msg);

        }

        $ch = curl_init();



        curl_setopt($ch, CURLOPT_URL,$url);

        if($postVars)
        {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,

                $postVars);
        }


        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);



        if (FALSE === $result)
            throw new \Exception(curl_error($ch), curl_errno($ch));

        if(stripos($result,'<?xml') === false)
        {
            throw new \Exception('Result is not xml response: '.$result);
        }

        curl_close($ch);

        return $result;
    }


} 