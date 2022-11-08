<?php

namespace CaioMarcatti12\QueueManager\Objects;


class QueueOptions
{
    private int $workers = 1;

    public function __construct(int $workers = 1)
    {
        $this->workers = $workers;
    }

    public function getWorkers(): int
    {
        return $this->workers;
    }
}