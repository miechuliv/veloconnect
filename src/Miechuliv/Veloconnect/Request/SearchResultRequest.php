<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 14.10.14
 * Time: 10:40
 */

namespace Miechuliv\Veloconnect\Request;
use Miechuliv\Veloconnect;


class SearchResultRequest implements  RequestInterface{

    public function request($baseUrl,$user_id,$pass,$params = array())
    {
        $request = new Request();
        $response = new Veloconnect\Response\SearchResultResponse();

        $fullUrl = $baseUrl;

        $post = "BuyersID=".$user_id."&Password=".$pass."&RequestName=SearchResultRequest&TransactionID=".$params['transaction_id']."&Count=".$params['count']."&ResultFormat=ITEM_DETAIL";

        $response->receive($request->execute($fullUrl,$post));

        $response->validateResponseCode($response,$request);

        return $response;
    }

} 