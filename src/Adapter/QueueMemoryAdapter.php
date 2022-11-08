<?php

namespace CaioMarcatti12\QueueManager\Adapter;

use CaioMarcatti12\QueueManager\Interfaces\QueueManagerInterface;

class QueueMemoryAdapter implements QueueManagerInterface
{
    public function publish(string $exchange, mixed $payload, array $options = []): void
    {

    }

    public function consume(string $queue, \Closure $callback): void
    {

    }
}