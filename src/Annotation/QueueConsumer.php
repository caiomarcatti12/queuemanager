<?php

namespace CaioMarcatti12\QueueManager\Annotation;

use Attribute;
use CaioMarcatti12\QueueManager\Objects\QueueOptions;


#[Attribute(Attribute::TARGET_CLASS)]
class QueueConsumer
{
    private string $queue;
    private QueueOptions $options;

    public function __construct(string $queue, ?QueueOptions $options = null)
    {
        $this->queue = $queue;

        if($options === null)
            $options = new QueueOptions();

        $this->options = $options;
    }

    public function getQueue(): string
    {
        return $this->queue;
    }

    public function getOptions(): QueueOptions
    {
        return $this->options;
    }
}