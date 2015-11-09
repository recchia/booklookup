<?php
/**
 * Created by PhpStorm.
 * User: recchia
 * Date: 09/11/15
 * Time: 04:35 PM
 */

namespace AppBundle\Factory;

use AppBundle\Entity\ApiVendor;
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
            $apiVendor = $this->apiVendorRepository->find($id);
        } elseif(is_string($id)) {
            $apiVendor = $this->apiVendorRepository->findByCode($id);
        }

        return $this->getAdapter($apiVendor);
    }

    protected function getAdapter(ApiVendor $apiVendor)
    {
        $className = "AppBundle\\Adapter\\" . $apiVendor->getAdapter();

        return new $className(['key' => $apiVendor->getKey()]);
    }
}