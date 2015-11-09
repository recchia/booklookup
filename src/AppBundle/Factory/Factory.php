<?php
/**
 * Created by PhpStorm.
 * User: recchia
 * Date: 09/11/15
 * Time: 04:31 PM
 */

namespace AppBundle\Factory;

abstract class Factory
{
    protected abstract function getObject();

    public function startFactory()
    {
        return $this->getObject();
    }
}