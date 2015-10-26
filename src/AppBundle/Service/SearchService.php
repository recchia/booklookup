<?php
/**
 * Created by PhpStorm.
 * User: recchia
 * Date: 22/10/15
 * Time: 04:20 PM
 */

namespace AppBundle\Service;

use AppBundle\Entity\ApiVendor;

class SearchService
{
    public function search(ApiVendor $vendor, array $books)
    {
        if(count($books) == 1) {
            $className = "AppBundle\\Adapter\\" . $vendor->getAdapter();
            $adapter = new $className(['key' => $vendor->getKey()]);

            return $adapter->findOne($books['isbn']);
        }
    }
}