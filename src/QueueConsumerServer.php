<?php

namespace CaioMarcatti12\QueueManager;

use CaioMarcatti12\Cli\Interfaces\ArgvParserInterface;
use CaioMarcatti12\Core\Factory\Annotation\Autowired;
use CaioMarcatti12\Core\Factory\InstanceFactory;
use CaioMarcatti12\Core\Factory\Invoke;
use CaioMarcatti12\Core\Launcher\Annotation\Launcher;
use CaioMarcatti12\Core\Launcher\Enum\LauncherPriorityEnum;
use CaioMarcatti12\Core\Launcher\Interfaces\LauncherInterface;
use CaioMarcatti12\Core\Modules\Modules;
use CaioMarcatti12\Core\Modules\ModulesEnum;
use CaioMarcatti12\Core\Shared\Interfaces\ServerRunInterface;
use CaioMarcatti12\Core\Validation\Assert;
use CaioMarcatti12\Data\Request\Objects\Body;
use CaioMarcatti12\QueueManager\Objects\RoutesQueue;
use CaioMarcatti12\Webserver\Exception\RouteNotFoundException;

class QueueConsumerServer implements ServerRunInterface
{
    #[Autowired]
    protected QueueManager $queueManager;

    public function run($queue = ''): void
    {
        if(!Modules::isEnabled(ModulesEnum::QUEUE_MANAGER)) return;

        $route = RoutesQueue::getRoute($queue);

        if(Assert::isEmpty($route)) throw new RouteNotFoundException($queue);

        $this->queueManager->consume($queue, function($payload) use ($route) {
            Body::set(json_decode($payload, true));
            Invoke::new($route->getClass(), $route->getClassMethod());
        });
    }
}