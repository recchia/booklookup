<?php
/**
 * Created by PhpStorm.
 * User: recchia
 * Date: 26/01/16
 * Time: 11:43 AM
 */

namespace AppBundle\Service;

use Symfony\Component\DependencyInjection\Container;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class ConsumerService implements ConsumerInterface
{
    private $webDir;
    private $container;

    public function __construct($rootDir, Container $container)
    {
        $this->webDir = $rootDir . '/../web/';
        $this->container = $container;
    }

    /**
     * @param AMQPMessage $msg The message
     *
     * @return mixed false to reject and requeue, any other value to aknowledge
     */
    public function execute(AMQPMessage $msg)
    {
        $payload = json_decode(unserialize($msg->body));

        echo sprintf("Id: %s Name: %s Path: %s Dir: %s" . PHP_EOL, $payload->id, $payload->name, $payload->path, $this->webDir);

        sleep(20);

        $client = $this->container->get('elephantio_client.default');

        $client->send('server_event',['name' => $payload->name, 'path' => $payload->path]);
    }}