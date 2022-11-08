<?php

namespace CaioMarcatti12\Webserver\Exception;

use CaioMarcatti12\Core\Bean\Annotation\AliasFor;
use CaioMarcatti12\Core\Bean\Enum\BeanType;
use Exception;

#[AliasFor(BeanType::EXCEPTION)]
final class InvalidArgumentRouteConstruct extends Exception
{
    public function __construct($route = '')
    {
        parent::__construct( 'Invalid argument route: '. $route, 500, null);
    }
}