<?php

namespace CaioMarcatti12\QueueManager\Interfaces;

interface QueueManagerInterface
{
    public function publish(string $exchange, mixed $payload, array $options = []): void;
    public function consume(string $queue, \Closure $callback): void;
}