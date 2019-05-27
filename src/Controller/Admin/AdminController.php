<?php
/**
 * Created by PhpStorm.
 * User: vladimir
 * Date: 06/02/19
 * Time: 19:35
 */

namespace App\Controller\Admin;

use App\Entity\Option;
use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/admin/property/{id}", name="admin.property.edit", requirements={"id": "[0-9]*"}, methods="GET|POST")
     * @param Property $property
     * @param Request $request
     * @return Response
     */
    public function edit(Property $property, Request $request): Response
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash("success", "Bien a été modifié avec succès");
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin\property\edit.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/{id}", name="admin.property.delete", methods="DELETE")
     * @param Property $property
     * @param Request $request
     * @return Response
     */
    public function delete(Property $property, Request $request): Response
    {
        if ($this->isCsrfTokenValid("delete" . $property->getId(), $request->get("_token")))
        {
            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash("success", "Bien a été supprimé avec succès");
        }

        return $this->redirectToRoute('admin.property.index');
    }
}