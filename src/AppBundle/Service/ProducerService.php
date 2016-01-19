<?php
/**
 * Created by PhpStorm.
 * User: recchia
 * Date: 19/01/16
 * Time: 03:06 PM
 */

namespace AppBundle\Service;

class ProducerService
{
    private $producer;

    public function __construct($producer)
    {
        $this->producer = $producer;
    }

    public function publish($message)
    {
        $this->producer->publish(serialize($message));
    }
}