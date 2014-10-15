<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 14.10.14
 * Time: 09:47
 */

namespace Miechuliv\Veloconnect\Request;

interface RequestInterface
{
    function request($baseUrl,$user_id,$pass,$params);
}