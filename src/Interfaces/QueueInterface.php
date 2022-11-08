<?php

namespace CaioMarcatti12\QueueManager\Interfaces;

interface QueueInterface
{
    public function handler(mixed $payload): void;
}