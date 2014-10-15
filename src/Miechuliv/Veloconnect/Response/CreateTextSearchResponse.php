<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 14.10.14
 * Time: 09:44
 */

namespace Miechuliv\Veloconnect\Response;


class CreateTextSearchResponse extends AbstractResponse{

    public $TotalCount;
    public $TransactionID;

    public function receive($data)
    {
        $this->data = $data;
        $xml = new \DOMDocument();
        @$xml->loadXML($data);

        $this->extractBasicData($xml);

        $obj = $xml->getElementsByTagNameNS('*','TotalCount');
        $this->TotalCount = is_object($obj->item(0))?$obj->item(0)->nodeValue:false;

        $obj = $xml->getElementsByTagNameNS('*','TransactionID');
        $this->TransactionID = is_object($obj->item(0))?$obj->item(0)->nodeValue:false;


    }

} 