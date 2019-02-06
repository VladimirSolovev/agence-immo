<?php
/**
 * Created by PhpStorm.
 * User: vladimir
 * Date: 06/02/19
 * Time: 19:35
 */

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;

class AdminController extends AbstractController
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
     * @Route("/admin", name="admin.property.index")
     * @return Response
     */
    public function index(): Response
    {
        $properties = $this->repository->findAll();

        return $this->render('admin\property\index.html.twig', [
            'properties' => $properties
        ]);
    }


    /**
     * @Route("/admin/{id}", name="admin.property.edit", requirements={"id": "[0-9]*"})
     * @param Property $property
     * @return Response
     */
    public function edit(Property $property): Response
    {

        $form = $this->createForm(PropertyType::class, $property);

        return $this->render('admin\property\edit.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }
}