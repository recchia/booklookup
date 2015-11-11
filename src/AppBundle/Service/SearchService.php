<?php
/**
 * Created by PhpStorm.
 * User: recchia
 * Date: 22/10/15
 * Time: 04:20 PM
 */

namespace AppBundle\Service;

use AppBundle\Factory\Factory;

class SearchService
{
    protected $adapterFactory;

    public function __construct(Factory $factory)
    {
        $this->adapterFactory = $factory;
    }

    public function search(array $data)
    {
        $isbn = explode(",", $data["isbn"]);

        $adapter = $this->adapterFactory->startFactory($data['api']);

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