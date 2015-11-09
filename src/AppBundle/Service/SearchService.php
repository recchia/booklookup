<?php
/**
 * Created by PhpStorm.
 * User: recchia
 * Date: 22/10/15
 * Time: 04:20 PM
 */

namespace AppBundle\Service;

class SearchService
{
    public function search(array $data)
    {
        if(count($data['isbn']) == 1) {
            $adapter = new $className(['key' => $vendor->getKey()]);

            return $adapter->findOne($books['isbn']);
        }
    }
}