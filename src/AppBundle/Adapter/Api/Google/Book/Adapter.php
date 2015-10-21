<?php
/**
 * Created by PhpStorm.
 * User: recchia
 * Date: 21/10/15
 * Time: 04:41 PM
 */

namespace AppBundle\Adapter\Api\Google\Book;

use AppBundle\Adapter\AdapterInterface;
use AppBundle\Exception\BookNotFoundException;


class Adapter implements AdapterInterface
{

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        // TODO: Implement __construct() method.
    }

    /**
     * @param string $isbn
     *
     * @return array
     *
     * @throws BookNotFoundException
     */
    public function findOne($isbn)
    {
        // TODO: Implement findOne() method.
    }

    /**
     * @param array $isbn
     *
     * @return array
     */
    public function find(array $isbn)
    {
        // TODO: Implement find() method.
    }
}