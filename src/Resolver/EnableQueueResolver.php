<?php

namespace CaioMarcatti12\QueueManager\Resolver;

use CaioMarcatti12\Core\Bean\Annotation\AnnotationResolver;
use CaioMarcatti12\Core\Bean\Interfaces\ClassResolverInterface;
use CaioMarcatti12\Core\Bean\Objects\BeanProxy;
use ReflectionClass;
use CaioMarcatti12\QueueManager\Annotation\EnableQueue;
use CaioMarcatti12\QueueManager\Interfaces\QueueManagerInterface;

#[AnnotationResolver(EnableQueue::class)]
class EnableQueueResolver implements ClassResolverInterface
{
    public function handler(object &$instance): void
    {
        $reflectionClass = new ReflectionClass($instance);

        $attributes = $reflectionClass->getAttributes(EnableQueue::class);

        /** @var EnableQueue $attribute */
        $attribute = ($attributes[0]->newInstance());

        BeanProxy::add(QueueManagerInterface::class, $attribute->getAdapter());
    }
}