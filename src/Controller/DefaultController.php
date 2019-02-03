<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    /**
     * @return Response
     * @Route("/", name="index")
     */
    public function index(PropertyRepository $repository):Response
    {
        $properties = $repository->findLatest();
        dump($properties);
        return $this->render('default\index.html.twig', [
            'properties' => $properties
        ]);
    }
}