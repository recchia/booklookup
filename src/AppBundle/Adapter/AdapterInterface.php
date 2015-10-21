<?php
/**
 * Created by PhpStorm.
 * User: recchia
 * Date: 21/10/15
 * Time: 04:38 PM
 */

namespace AppBundle\Adapter;

use AppBundle\Exception\BookNotFoundException;


interface AdapterInterface
{
    /**
     * @param array $config
     */
    public function __construct(array $config);

    /**
     * @param string $isbn
     *
     * @return array
     *
     * @throws BookNotFoundException
     */
    public function findOne($isbn);

    /**
     * @param array $isbn
     *
     * @return array
     */
    public function find(array $isbn);
}