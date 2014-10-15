<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 14.10.14
 * Time: 10:37
 */

namespace Miechuliv\Veloconnect\Transaction;
use Miechuliv\Veloconnect;

class TextSearchTransaction extends AbstractTransaction{

    public function execute($baseUrl,$user_id,$pass,$params = array())
    {
        $this->currentStep = 1;
        $req = new Veloconnect\Request\CreateTextSearchRequest();
        $response = $req->request($baseUrl,$user_id,$pass);

        $this->currentStep = 2;
        $this->TransactionID = $response->TransactionID;

        $req = new Veloconnect\Request\SearchResultRequest();
        $response = $req->request($baseUrl,$user_id,$pass,array('transaction_id' => $this->TransactionID,'count' => isset($params['count'])?$params['count']:$response->TotalCount));

        return $response;

    }
} 