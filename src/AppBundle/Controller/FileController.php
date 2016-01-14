<?php

namespace AppBundle\Controller;

use AppBundle\Entity\File;
use AppBundle\Form\Type\FileType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/", name="files_list")
     */
    public function indexAction()
    {
        return $this->render(":File:index.html.twig");
    }

    /**
     * @Route("/new", name="new_file")
     */
    public function newAction()
    {
        $form = $this->createForm(new FileType(new File()));

        return $this->render(":File:new.html.twig", ["form" => $form->createView()]);
    }

    /**
     * @Route("/upload", name="upload_file")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function uploadAction(Request $request)
    {
        $form = $this->createForm(new FileType());

        $form->handleRequest($request);

        if($form->isValid()) {
            $file = $form->getData();
            $file->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($file);
            $em->flush();

            $this->addFlash("success", "File created!");

            return $this->redirectToRoute("files_list");
        }

        return $this->render(":File:new.html.twig", ["form" => $form->createView()]);
    }

}
