<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 14.10.14
 * Time: 09:41
 */

namespace Miechuliv\Veloconnect\Request;

use Miechuliv\Veloconnect;


class CreateTextSearchRequest implements RequestInterface{

    public function request($baseUrl,$user_id,$pass,$params = array())
    {
        $request = new Request();
        $response = new Veloconnect\Response\CreateTextSearchResponse();

        $fullUrl = $baseUrl;

        $post = "BuyersID=".$user_id."&Password=".$pass."&RequestName=CreateTextSearchRequest";

        $response->receive($request->execute($fullUrl,$post));

        $response->validateResponseCode($response,$request);

        return $response;
    }
} 