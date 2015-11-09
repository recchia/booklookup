<?php
/**
 * Created by PhpStorm.
 * User: recchia
 * Date: 09/11/15
 * Time: 04:51 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ApiVendorRepository extends EntityRepository
{
    public function findByCode($code)
    {
        return $this->findOneBy(['code' => $code]);
    }
}