<?php

namespace CaioMarcatti12\QueueManager\Objects;

use CaioMarcatti12\Core\Validation\Assert;
use CaioMarcatti12\Webserver\Exception\RouteDuplicatedException;

class RoutesQueue
{
    private static array $routes = [];

    public static function add(Route $route): void {

        if(self::getRoute($route->getRoute()))
            throw new RouteDuplicatedException($route);

        self::$routes[] = $route;
    }

    public static function getRoute(string $requestUri): ?Route
    {
        $route = array_filter(self::$routes, function (Route $route) use ($requestUri) {
            return (Assert::equals($route->getRoute(), $requestUri));
        });

        if(Assert::isEmpty($route)) return null;

        return array_shift($route);
    }

    public static function destroy(): void{
        self::$routes = [];
    }
}