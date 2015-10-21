<?php

namespace AppBundle\Controller;

use AppBundle\Adapter\Api\Google\Book\Adapter;
use AppBundle\Exception\BookNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use \Google_Service_Exception;

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
        try {
            $api = new Adapter(['key' => '-fn6FtEs12n5CsbFXQQgDU']);
            dump($api->findOne('3822809128'));
            die();
        } catch (BookNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        } catch (Google_Service_Exception $e) {
            $messages = [];
            foreach ($e->getErrors() as $error) {
                $messages[] = implode(' | ', $error);
            }
            $info = implode(' - ', $messages);
            throw new HttpException('500', $info);
        }
    }
}
