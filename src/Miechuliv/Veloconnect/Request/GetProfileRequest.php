<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 14.10.14
 * Time: 09:30
 */

namespace Miechuliv\Veloconnect\Request;

use Miechuliv\Veloconnect;

class GetProfileRequest implements RequestInterface{

        public function request($baseUrl,$user_id,$pass,$params = array())
        {
            $request = new Request();
            $response = new Veloconnect\Response\GetProfileResponse();

            $fullUrl = $baseUrl.'?BuyersID='.$user_id.'&Password='.$pass.'&RequestName=GetProfileRequest';

            $response->receive($request->execute($fullUrl));

            $response->validateResponseCode($response,$request);

            return $response;
        }
} 