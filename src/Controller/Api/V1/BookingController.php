<?php

namespace App\Controller\Api\V1;

use App\Entity\Booking;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class BookingController extends AbstractController
{
    #[Route('/api/v1/bookings', name: 'bookings_store', methods: ['POST'])]
    public function store(Request $request, EntityManagerInterface $entityManager, SessionRepository $sessionRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $booking = new Booking();
        $booking->setName($data['name']);
        $booking->setEmail($data['email']);
        $booking->setPhone($data['phone']);
        $booking->setTotal($data['total']);

        $sessions = $sessionRepository->findByIds(array_map(fn($session) => $session['id'], $data['items']));

        if (count($sessions) !== count($data['items'])) {
            return $this->json(['message' => 'Session not available'], 400);
        }

        $sessions = array_combine(array_map(fn($session) => $session->getId(), $sessions), $sessions);

        $totalPrice = 0;
        foreach ($data['items'] as $item) {
            if (!isset($sessions[$item['id']]) || !$sessions[$item['id']]->getIsAvailable()) {
                return $this->json(['message' => 'Session not available'], 400);
            }

            $session = $sessions[$item['id']];
            $booking->addSession($session);
            $session->setIsAvailable(false);
            $totalPrice += $session->getPrice();
        }

        if ($totalPrice != $data['total']) {
            return $this->json(['message' => 'Total price mismatch'], 400);
        }

        $entityManager->persist($booking);
        $entityManager->flush();

        return $this->json(['message' => 'Booking created successfully'], 201);
    }
}
