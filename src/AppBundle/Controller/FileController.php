<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\FileType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class FileController
 *
 * @package AppBundle\Controller
 *
 * @Route("/file")
 */
class FileController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array(
                // ...
            );    }

    /**
     * @Route("/new")
     */
    public function newAction()
    {
        $form = $this->createForm(new FileType());

        return $this->render(":File:new.html.twig", ["form" => $form->createView()]);
    }

}
