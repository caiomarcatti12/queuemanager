<?php

namespace CaioMarcatti12\QueueManager\Objects;

use CaioMarcatti12\Webserver\Exception\InvalidArgumentRouteConstruct;

class Route
{
    private string $route;
    private string $class;
    private string $classMethod;

    public function __construct(string $route, string $class, string $classMethod)
    {
        if(empty($class)) throw new InvalidArgumentRouteConstruct('class');
        if(empty($classMethod)) throw new InvalidArgumentRouteConstruct('classMethod');

        $this->route = str_replace('//', '/', $route);
        $this->class = $class;
        $this->classMethod = $classMethod;
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getClassMethod(): string
    {
        return $this->classMethod;
    }
}