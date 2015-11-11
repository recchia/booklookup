<?php
/**
 * Created by PhpStorm.
 * User: recchia
 * Date: 22/10/15
 * Time: 04:20 PM
 */

namespace AppBundle\Service;

use AppBundle\Entity\ApiVendor;
use AppBundle\Factory\Factory;

class SearchService
{
    protected $adapterFactory;

    public function __construct(Factory $factory)
    {
        $this->adapterFactory = $factory;
    }

    public function search(ApiVendor $vendor, $isbn)
    {
        $isbn = explode(",", $isbn);

        $adapter = $this->adapterFactory->startFactory($vendor);

        $books = [];

        if(count($isbn) == 1) {
            $books[] = $adapter->findOne($isbn[0]);
        } else {
            foreach ($isbn as $value) {
                $books[] = $adapter->findOne($value);
            }
        }

        return $books;
    }
}