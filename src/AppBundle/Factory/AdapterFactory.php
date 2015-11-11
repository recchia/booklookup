<?php
/**
 * Created by PhpStorm.
 * User: recchia
 * Date: 09/11/15
 * Time: 04:35 PM
 */

namespace AppBundle\Factory;

use AppBundle\Entity\ApiVendor;

class AdapterFactory extends Factory
{
    protected function getObject(ApiVendor $vendor)
    {
        return $this->getAdapter($vendor);
    }

    protected function getAdapter(ApiVendor $apiVendor)
    {
        $className = "AppBundle\\Adapter\\" . $apiVendor->getAdapter();

        return new $className(['key' => $apiVendor->getKey()]);
    }
}