<?php
/**
 * Created by PhpStorm.
 * User: recchia
 * Date: 22/10/15
 * Time: 04:47 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ApiVendor
 *
 * @package AppBundle\Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ApiVendorRepository")
 */
class ApiVendor
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=8, unique=true, name="api_code")
     */
    protected $code;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=60, unique=true, name="api_name")
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=128, name="api_key")
     */
    protected $key;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=254)
     */
    protected $adapter;

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @param string $adapter
     */
    public function setAdapter($adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

}