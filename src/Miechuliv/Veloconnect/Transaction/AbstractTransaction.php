<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 14.10.14
 * Time: 10:36
 */

namespace Miechuliv\Veloconnect\Transaction;


abstract class AbstractTransaction {

    public $currentStep;
    public $TransactionID;

    abstract public function execute($baseUrl,$user_id,$pass,$params);

} 