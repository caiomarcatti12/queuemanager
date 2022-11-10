<?php

namespace CaioMarcatti12\QueueManager;

use CaioMarcatti12\Cli\Interfaces\ArgvParserInterface;
use CaioMarcatti12\Core\Factory\Annotation\Autowired;
use CaioMarcatti12\Core\Factory\InstanceFactory;
use CaioMarcatti12\Core\Factory\Invoke;
use CaioMarcatti12\Core\Validation\Assert;
use CaioMarcatti12\Data\Request\Objects\Body;
use CaioMarcatti12\QueueManager\Objects\RoutesQueue;
use CaioMarcatti12\Webserver\Exception\RouteNotFoundException;

class QueueConsumerServer
{
    #[Autowired]
    protected QueueManager $queueManager;

    #[Autowired]
    protected ArgvParserInterface $argvParser;

    public function run(): void
    {
        $queue = $this->argvParser->get('queue', '');

        $route = RoutesQueue::getRoute($queue);

        if(Assert::isEmpty($route)) throw new RouteNotFoundException($queue);

        $this->queueManager->consume($queue, function($payload) use ($route) {
            Body::set(json_decode($payload, true));
            Invoke::new($route->getClass(), $route->getClassMethod());
        });
    }
}