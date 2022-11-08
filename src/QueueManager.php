<?php

namespace CaioMarcatti12\QueueManager;

use CaioMarcatti12\Core\Factory\Annotation\Autowired;
use CaioMarcatti12\Core\Validation\Assert;
use CaioMarcatti12\Data\ObjectMapper;
use CaioMarcatti12\QueueManager\Interfaces\QueueManagerInterface;

class QueueManager implements QueueManagerInterface
{
    #[Autowired]
    private QueueManagerInterface $queueManager;

    public function publish(string $exchange, mixed $payload, array $options = []): void
    {
        $type = gettype($payload);

        if(!Assert::isPrimitiveTypeName($type)){
            $payload = ObjectMapper::toArray($payload);
        }

        $payload = json_encode($payload);

        $this->queueManager->publish($exchange, $payload, $options);
    }

    public function consume(string $queue, \Closure $callback): void
    {
        $this->queueManager->consume($queue, $callback);
    }
}