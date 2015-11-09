<?php
/**
 * Created by PhpStorm.
 * User: recchia
 * Date: 09/11/15
 * Time: 04:35 PM
 */

namespace AppBundle\Factory;

use Doctrine\ORM\EntityRepository;

class ApiFactory extends Factory
{
    private $apiVendorRepository;

    public function __construct(EntityRepository $entityRepository)
    {
        $this->apiVendorRepository = $entityRepository;
    }

    protected function getObject($id)
    {
        if(is_int($id)) {
            return $this->apiVendorRepository->find($id);
        } elseif(is_string($id)) {
            return $this->apiVendorRepository->findByCode($id);
        }
    }
}