<?php

namespace App\Controller\Api\V1;

use App\Entity\Booking;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BookingController extends AbstractController
{
    #[Route('/api/v1/bookings', name: 'bookings_store', methods: ['POST'])]
    public function store(Request $request, EntityManagerInterface $entityManager, SessionRepository $sessionRepository, ValidatorInterface $validator): JsonResponse
    {
        $constraint = new Assert\Collection([
            'name' => new Assert\NotBlank(),
            'email' => [
                new Assert\NotBlank(),
                new Assert\Email()
            ],
            'phone' => new Assert\NotBlank(),
            'items' => [
                new Assert\Count([
                    'min' => 1
                ]),
                new Assert\All([
                    new Assert\Collection([
                        'id' => new Assert\NotBlank(),
                    ])
                ])
            ]
        ]);

        $groups = new Assert\GroupSequence(['Default', 'custom']);
        $data = json_decode($request->getContent(), true);
        $violations = $validator->validate($data, $constraint, $groups);

        if (count($violations) > 0) {
            $violations = array_map(fn($violation) => ['field' => $violation->getPropertyPath(), 'message' => $violation->getMessage()], iterator_to_array($violations));
            return $this->json(['message' => 'Validation failed', 'errors' => $violations], 400);
        }

        $booking = new Booking();
        $booking->setName($data['name']);
        $booking->setEmail($data['email']);
        $booking->setPhone($data['phone']);

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

        $booking->setTotal($totalPrice);

        $entityManager->persist($booking);
        $entityManager->flush();

        return $this->json(['message' => 'Booking created successfully'], 201);
    }
}
