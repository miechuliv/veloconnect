<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 14.10.14
 * Time: 11:12
 */

namespace Miechuliv\Veloconnect\Response;
use Miechuliv\Veloconnect;

class SearchResultResponse extends AbstractResponse{

    public $items;

    public function receive($data)
    {
        $this->data = $data;
        $xml = new \DOMDocument();
        @$xml->loadXML($data);

        $this->extractBasicData($xml);

        $items = $xml->getElementsByTagNameNS('*','Item');

        $this->items = array();

        if($items->length)
        {

            foreach($items as $item)
            {
                $itemObj = new Veloconnect\ComplexTypes\Item();
                $this->items[] = $itemObj;

                $obj = $item->getElementsByTagNameNS('*','Description');
                $itemObj->Description = is_object($obj->item(0))?$obj->item(0)->nodeValue:false;

                $obj = $item->getElementsByTagNameNS('*','SellersItemIdentification');
                if(is_object($obj->item(0)))
                {
                    $obj2 = $obj->item(0)->getElementsByTagNameNS('*','ID');
                    $itemObj->SellersItemIdentification = is_object($obj2->item(0))?$obj2->item(0)->nodeValue:false;
                }

                $obj = $item->getElementsByTagNameNS('*','StandardItemIdentification');

                if(is_object($obj->item(0)))
                {
                    $obj2 = $obj->item(0)->getElementsByTagNameNS('*','ID');
                    $itemObj->StandardItemIdentification = is_object($obj2->item(0))?$obj2->item(0)->nodeValue:false;
                }

                $classification = $item->getElementsByTagNameNS('*','ClassificationGroupMember');
                if(is_object($classification->item(0)))
                {
                    $classificationObj = new Veloconnect\ComplexTypes\ClassificationGroupMember();
                    $obj2 = $classification->item(0)->getElementsByTagNameNS('*','ClassificationSchemeID');
                    $classificationObj->ClassificationSchemeID = is_object($obj2->item(0))?$obj2->item(0)->nodeValue:false;

                    $obj2 = $classification->item(0)->getElementsByTagNameNS('*','GroupID');
                    $classificationObj->GroupID = is_object($obj2->item(0))?$obj2->item(0)->nodeValue:false;

                    $itemObj->ClassificationGroupMember[] = $classificationObj;

                }

                $obj = $item->getElementsByTagNameNS('*','BasePrice');
                if(is_object($obj->item(0)))
                {
                    $basePriceObj = new Veloconnect\ComplexTypes\BasePrice();

                    $obj2 = $obj->item(0)->getElementsByTagNameNS('*','PriceAmount');
                    $basePriceObj->PriceAmount = is_object($obj2->item(0))?$obj2->item(0)->nodeValue:false;

                    if(is_object($obj2->item(0)))
                    {
                        $attributes = $obj2->item(0)->attributes;
                        foreach($attributes as $node => $value)
                        {
                            if($node == 'amountCurrencyID')
                            {
                                $basePriceObj->amountCurrencyId = $value->value;
                            }
                        }
                    }

                    $obj2 = $obj->item(0)->getElementsByTagNameNS('*','BaseQuantity');
                    $basePriceObj->BaseQuantity = is_object($obj2->item(0))?$obj2->item(0)->nodeValue:false;

                    if(is_object($obj2->item(0)))
                    {
                        $attributes = $obj2->item(0)->attributes;
                        foreach($attributes as $node => $value)
                        {
                            if($node == 'quantityUnitCode')
                            {
                                $basePriceObj->quantityUnitCode = $value->value;
                            }
                        }
                    }

                    $itemObj->BasePrice = $basePriceObj;


                }


                $obj = $item->getElementsByTagNameNS('*','RecommendedRetailPrice');
                if(is_object($obj->item(0)))
                {
                $recommendedRetailPriceObj = new Veloconnect\ComplexTypes\RecommendedRetailPrice();

                $obj2 = $obj->item(0)->getElementsByTagNameNS('*','PriceAmount');
                $recommendedRetailPriceObj->PriceAmount = is_object($obj2->item(0))?$obj2->item(0)->nodeValue:false;

                if(is_object($obj2->item(0)))
                {
                    $attributes = $obj2->item(0)->attributes;
                    foreach($attributes as $node => $value)
                    {
                        if($node == 'amountCurrencyID')
                        {
                            $recommendedRetailPriceObj->amountCurrencyId = $value->value;
                        }
                    }
                }

                $obj2 = $obj->item(0)->getElementsByTagNameNS('*','BaseQuantity');
                $recommendedRetailPriceObj->BaseQuantity = is_object($obj2->item(0))?$obj2->item(0)->nodeValue:false;

                if(is_object($obj2->item(0)))
                {
                    $attributes = $obj2->item(0)->attributes;
                    foreach($attributes as $node => $value)
                    {
                        if($node == 'quantityUnitCode')
                        {
                            $recommendedRetailPriceObj->quantityUnitCode = $value->value;
                        }
                    }
                }

                $itemObj->RecommendedRetailPriceObj = $recommendedRetailPriceObj;

                }


                $information = $item->getElementsByTagNameNS('*','ItemInformation');

                if($information->length)
                {
                    $this->_getItemInformation($information,$itemObj);
                }

                $obj = $item->getElementsByTagNameNS('*','Availability');
                $itemObj->Availability = is_object($obj->item(0))?$obj->item(0)->nodeValue:false;
            }
        }



    }

    private function _getItemInformation(\DOMNodeList $information, Veloconnect\ComplexTypes\Item $item)
    {
        foreach($information as $info)
        {
            $obj = $info->getElementsByTagNameNS('*','Disposition');
            $informationObj = new Veloconnect\ComplexTypes\InformationURL();
            $informationObj->Disposition = $disposition =  is_object($obj->item(0))?$obj->item(0)->nodeValue:false;

            $obj = $info->getElementsByTagNameNS('*','URI');
            $informationObj->URI = $URI = is_object($obj->item(0))?$obj->item(0)->nodeValue:false;

            if($disposition == 'tech_spec')
            {
                $data = file_get_contents($URI);

                if(!empty($data))
                {
                    $techSpecObj = new Veloconnect\ComplexTypes\TechSpec();
                    $xml = new \DOMDocument();
                    $xml->loadXML('<?xml version="1.0" encoding="UTF-8" ?>'.$data);

                    $obj = $xml->getElementsByTagName('item');
                    if(is_object($obj->item(0)))
                    {
                        foreach($obj->item(0)->childNodes as $child)
                        {
                            $techSpecObj->data[$child->nodeName] = $child->nodeValue;
                        }
                    }

                    $item->TechSpec = $techSpecObj;
                }
            }
            elseif($disposition == 'picture')
            {
                $item->Images[] = $URI;
            }
            elseif($disposition == 'pdf')
            {
                $item->PDF[] = $URI;
            }

            $item->ItemInformation[] = $informationObj;

        }
    }



} 