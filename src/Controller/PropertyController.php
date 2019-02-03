<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    /**
     * @return Response
     * @Route("properties", name="property.index")
     */
    public function showProperties(): Response
    {
        return $this->render('property\index.html.twig', [
            'current_menu' => 'properties'
        ]);
    }
}