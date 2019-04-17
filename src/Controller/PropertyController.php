<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Query;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(PropertyRepository $repository, ObjectManager $manager)
    {
        $this->repository = $repository;
        $this->em = $manager;
    }

    /**
     * @Route("/properties", name="property.index")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function showProperties(PaginatorInterface $paginator, Request $request): Response
    {
        $properties = $paginator->paginate($this->repository->findAllAvailibleQuery(), $request->query->getInt('page', 1), 12);

        return $this->render('property\index.html.twig', [
            'current_menu' => 'properties',
            'properties' => $properties
        ]);
    }


    /**
     * @return Response
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*", "id": "[0-9]*"})
     */
    public function show(Property $property, string $slug): Response
    {
        if ($property->getSlug() !== $slug)
        {
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }

        return $this->render('property\show.html.twig', [
            'current_menu' => 'properties',
            'property' => $property
            ]);

    }
}