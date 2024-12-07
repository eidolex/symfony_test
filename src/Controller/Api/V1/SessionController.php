<?php

namespace App\Controller\Api\V1;

use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class SessionController extends AbstractController
{
    #[Route("/api/v1/sessions", name: "session_list", methods: ["GET"])]
    public function index(
        SessionRepository $sessionRepository,
        Request $request
    ): JsonResponse {
        $sessions = $sessionRepository->filter($request->query->all());

        $data = [];

        foreach ($sessions as $session) {
            $date = $session->getTime()->format("Y-m-d");
            if (!isset($data[$date])) {
                $data[$date] = [
                    "types" => [],
                    "sessions" => [],
                ];
            }

            if (!isset($data[$date]["types"][$session->getType()->value])) {
                $data[$date]["types"][$session->getType()->value] = 0;
            }
            $data[$date]["types"][$session->getType()->value]++;
            $data[$date]["sessions"][] = $session;
        }

        return $this->json(
            [
                "data" => $data,
            ],
            200,
            []
        );
    }
}
