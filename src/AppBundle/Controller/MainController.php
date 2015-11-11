<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        $form = $this->createForm(new SearchType());

        return $this->render(':Main:index.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param Request $request
     *
     * @return array
     *
     * @Route("/search", name="single_search")
     */
    public function searchAction(Request $request)
    {
        $form = $this->createForm(new SearchType());
        $form->handleRequest($request);

        if($form->isValid()) {
            $data = $form->getData();

            $books = $this->get("api.search")->search($data['api'], $data['isbn']);

            if ($request->isXmlHttpRequest()) {
                return new JsonResponse($books);
            } else {
                return $this->render(":Main:search.html.twig", ['result' => $books]);
            }
        } else {
            return $this->redirect($this->generateUrl('home'), ['form' => $form->createView()]);
        }
    }
}
