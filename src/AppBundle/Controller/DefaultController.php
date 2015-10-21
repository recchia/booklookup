<?php

namespace AppBundle\Controller;

use AppBundle\Adapter\Api\Google\Book\Adapter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }

    /**
     * @Route("/search")
     */
    public function searchAction()
    {
        $api = new Adapter(['key' => 'AIzaSyDfR5cB9PNeD-fn6FtEs12n5CsbFXQQgDU']);
        dump($api->findOne('3822809128'));
        die();
    }
}
