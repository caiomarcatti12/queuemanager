<?php

namespace CaioMarcatti12\Webserver\Resolver;

use CaioMarcatti12\Core\Bean\Annotation\AnnotationResolver;
use CaioMarcatti12\Core\Bean\Interfaces\ClassResolverInterface;
use CaioMarcatti12\Core\Bean\Objects\BeanProxy;
use CaioMarcatti12\Webserver\Annotation\EnableWebServer;
use CaioMarcatti12\Webserver\Interfaces\WebServerRunnerInterface;
use ReflectionClass;

#[AnnotationResolver(EnableWebServer::class)]
class EnableWebServerResolver  implements ClassResolverInterface
{
    public function handler(object &$instance): void
    {
        $reflectionClass = new ReflectionClass($instance);

        $attributes = $reflectionClass->getAttributes(EnableWebServer::class);

        /** @var EnableWebServer $attribute */
        $attribute = ($attributes[0]->newInstance());

        BeanProxy::add(WebServerRunnerInterface::class, $attribute->getAdapter());
    }
}