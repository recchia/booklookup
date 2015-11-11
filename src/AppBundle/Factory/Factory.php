<?php
/**
 * Created by PhpStorm.
 * User: recchia
 * Date: 09/11/15
 * Time: 04:31 PM
 */

namespace AppBundle\Factory;

use AppBundle\Entity\ApiVendor;

abstract class Factory
{
    protected abstract function getObject(ApiVendor $vendor);

    public function startFactory($vendor)
    {
        return $this->getObject($vendor);
    }
}