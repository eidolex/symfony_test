<?php

namespace App\Controller\Api\V1;

use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class SessionController extends AbstractController
{
    #[Route('/api/v1/sessions', name: 'session_list', methods: ['GET'])]
    public function index(SessionRepository $sessionRepository, Request $request): JsonResponse
    {
        $sessions = $sessionRepository->filter($request->query->all());

        return $this->json($sessions, 200, []);
    }
}
