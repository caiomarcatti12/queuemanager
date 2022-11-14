<?php

namespace CaioMarcatti12\QueueManager\Adapter;


use CaioMarcatti12\Env\Objects\Property;
use CaioMarcatti12\QueueManager\Interfaces\QueueManagerInterface;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQAdapter implements QueueManagerInterface
{
    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;

    public function __construct()
    {
        $host = Property::get('queue.rabbitmq.host','host.docker.internal');
        $port = Property::get('queue.rabbitmq.port', '5672');
        $username = Property::get('queue.rabbitmq.username', 'guest');
        $password = Property::get('queue.rabbitmq.password', 'guest');
        $vhost = Property::get('queue.rabbitmq.vhost', '/');

        $this->connection = new AMQPStreamConnection($host, $port, $username, $password,$vhost);

        $this->channel = $this->connection->channel();
    }

    public function publish(string $exchange, mixed $payload, array $options = []): void
    {
        $pattern = $options['pattern'] ?? '';

         $this->channel->basic_publish(new AMQPMessage($payload,['delivery_mode' => 2]), $exchange, $pattern);
    }

    public function consume(string $queue, \Closure $callback): void
    {
        $this->channel->basic_qos(null, 1, null);
        $this->channel->basic_consume($queue, '', false, false, false, false, function ($msg) use ($callback) {
            try {
//                $headers = $msg->get_properties()['application_headers']->getNativeData() ?? [];

                $callback($msg->body);
                $msg->ack();
            } catch (\Exception $e) {
                $msg->reject();
            }
        });

        while ($this->channel->is_open()) {
            $this->channel->wait();
        }

        exit(1);
    }
}