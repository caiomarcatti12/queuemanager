<?php

namespace CaioMarcatti12\Webserver\Exception;

use CaioMarcatti12\Core\Bean\Annotation\AliasFor;
use CaioMarcatti12\Core\Bean\Enum\BeanType;
use Exception;

#[AliasFor(BeanType::EXCEPTION)]
final class RouteNotFoundException extends Exception
{
    public function __construct($route = '')
    {
        parent::__construct('Route not found: '.$route, '500', null);
    }
}