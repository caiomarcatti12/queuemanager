<?php

namespace CaioMarcatti12\QueueManager\Annotation;

use Attribute;
use CaioMarcatti12\Core\Modules\Modules;
use CaioMarcatti12\Core\Modules\ModulesEnum;
use CaioMarcatti12\QueueManager\Adapter\RabbitMQAdapter;

#[Attribute(Attribute::TARGET_CLASS)]
class EnableQueue
{
    private string $adapter = '';

    public function __construct(string $adapter = RabbitMQAdapter::class)
    {
        $this->adapter = $adapter;

        Modules::enable(ModulesEnum::QUEUE_MANAGER);
    }

    public function getAdapter(): string
    {
        return $this->adapter;
    }
}
