<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 14.10.14
 * Time: 10:40
 */

namespace Miechuliv\Veloconnect\Request;
use Miechuliv\Veloconnect;


class GetClassificationSchemeRequest implements  RequestInterface{

    public function request($baseUrl,$user_id,$pass,$params = array())
    {
        $request = new Request();
        $response = new Veloconnect\Response\GetClassificationSchemeResponse();

        $fullUrl = $baseUrl;

        $post = "BuyersID=".$user_id."&Password=".$pass."&RequestName=GetClassificationSchemeRequest";

        $response->receive($request->execute($fullUrl,$post));

        $response->validateResponseCode($response,$request);

        return $response;
    }

} 