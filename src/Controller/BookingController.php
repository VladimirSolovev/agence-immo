<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Property;
use App\Form\BookingType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class BookingController extends AbstractController
{
    /**
     * @Route("/properties/{id}/book", name="booking.create")
     * @IsGranted("ROLE_USER")
     */
    public function book(Property $property, Request $request, ObjectManager $manager)
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();

            $booking->setBooker($user)
                    ->setAd($property);

            $manager->persist($booking);
            $manager->flush();

            return $this->redirectToRoute('booking.success', [
                'id' => $booking->getId(),
                'confirmationAlert' => true
                ]);
        }

        return $this->render('booking/book.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/booking/{id}", name="booking.success")
     * @IsGranted("ROLE_USER")
     * @param Booking $booking
     * @return Response
     */
    public function show(Booking $booking): Response {
        return $this->render('booking/show.html.twig', [
            'booking' => $booking
        ]);
    }
}
