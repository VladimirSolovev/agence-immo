<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/image")
 */
class AdminImageController extends AbstractController
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
     * @Route("/{id}", name="admin.image.delete", methods="DELETE")
     * @param Image $image
     * @param Request $request
     * @return Response
     */
    public function delete (Image $image, Request $request): Response {
        $data = json_decode($request->getContent(), true);
        if ($this->isCsrfTokenValid("delete" . $image->getId(), $data["_token"]))
        {
            $this->em->remove($image);
            $this->em->flush();
            $this->addFlash("success", "Image a été supprimée avec succès");
            return new JsonResponse(['success' => 1]);
        }
        return new JsonResponse(['error' => 'Token invalid.'], 400);
    }
}