<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 14.10.14
 * Time: 10:09
 */

namespace Miechuliv\Veloconnect\Response;
use Miechuliv\Veloconnect;


abstract class AbstractResponse {

    public $data;
    public $responseCode;
    public $isTest;

    abstract public function receive($data);

    public function extractBasicData(\DOMDocument $dom)
    {
        $obj = $dom->getElementsByTagNameNS('*','ResponseCode');
        $this->responseCode = is_object($obj->item(0))?$obj->item(0)->nodeValue:false;

        $obj = $dom->getElementsByTagNameNS('*','IsTest');
        $this->isTest = is_object($obj->item(0))?$obj->item(0)->nodeValue:false;


    }

    public function validateResponseCode($response,$request)
    {
        if(!$response->responseCode || $response->responseCode != 200)
        {
            $msg = 'Response code is not 200, response code: '.$response->responseCode.' , request: '.get_class($request).' , response: '.get_class($response).'';
            Veloconnect\Logger::log($msg.' , response data: '.$response->data);
            throw new \Exception($msg);

        }
    }

    /*public function buildComplexType($type,\DOMDocument $xml)
    {
        $vars = get_object_vars($type);

        foreach($vars as $var)
        {
            if(is_array($var))
            {
                $objs = $xml->getElementsByTagNameNS('*',$var);
            }
            else
            {
                $obj = $xml->getElementsByTagNameNS('*',$var);
                $type->$var = is_object($obj->item(0))?$obj->item(0)->nodeValue:false;
            }
        }
    }*/

} 