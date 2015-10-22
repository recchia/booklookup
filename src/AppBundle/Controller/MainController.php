<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        return $this->render(':Main:index.html.twig');
    }

    /**
     * @Route("/search", name="single_search")
     */
    public function searchAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            //json response
        } else {
            //search
        }
        return [];
    }
}
