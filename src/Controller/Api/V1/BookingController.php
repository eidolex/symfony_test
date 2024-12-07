<?php

namespace App\Controller\Api\V1;

use App\Dto\BookingDto;
use App\Entity\Booking;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class BookingController extends AbstractController
{
    #[Route("/api/v1/bookings", name: "bookings_store", methods: ["POST"])]
    public function store(
        #[MapRequestPayload(acceptFormat: "json")] BookingDto $bookingDto,
        EntityManagerInterface $entityManager,
        SessionRepository $sessionRepository,
        MailerInterface $mailer
    ): JsonResponse {
        $booking = new Booking();
        $booking->setName($bookingDto->name);
        $booking->setEmail($bookingDto->email);
        $booking->setPhone($bookingDto->phone);

        $sessions = $sessionRepository->findByIds(
            array_map(fn($session) => $session["id"], $bookingDto->items)
        );

        if (count($sessions) !== count($bookingDto->items)) {
            return $this->json(["message" => "Session not available"], 400);
        }

        $sessions = array_combine(
            array_map(fn($session) => $session->getId(), $sessions),
            $sessions
        );

        $totalPrice = 0;
        foreach ($bookingDto->items as $item) {
            if (
                !isset($sessions[$item["id"]]) ||
                !$sessions[$item["id"]]->getIsAvailable()
            ) {
                return $this->json(["message" => "Session not available"], 400);
            }
            $session = $sessions[$item["id"]];
            $booking->addSession($session);
            $session->setIsAvailable(false);
            $totalPrice += $session->getPrice();
        }

        $booking->setTotal($totalPrice);

        $entityManager->persist($booking);
        $entityManager->flush();

        $email = (new Email())
            ->from("sandaraion@gmail.com")
            ->to($bookingDto->email)
            ->subject("You have successfully booked a session")
            ->text("You have successfully booked a session")
            ->html("<p>You have successfully booked a session</p>");

        $mailer->send($email);

        return $this->json(["message" => "Booking created successfully"], 201);
    }
}
