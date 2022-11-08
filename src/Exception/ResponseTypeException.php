<?php

namespace CaioMarcatti12\Webserver\Exception;

use CaioMarcatti12\Core\Bean\Annotation\AliasFor;
use CaioMarcatti12\Core\Bean\Enum\BeanType;
use Exception;

#[AliasFor(BeanType::EXCEPTION)]
final class ResponseTypeException extends Exception
{
    public function __construct()
    {
        parent::__construct('Error response type', 500, null);
    }
}