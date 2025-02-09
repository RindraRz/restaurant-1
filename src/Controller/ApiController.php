<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends AbstractController
{
    #[Route('/api/hello', name: 'api_hello')]
    public function hello(): JsonResponse
    {
        return new JsonResponse(['message' => 'Hello, World!']);
    }

    #[Route('/api/profile', name: 'api_profile', methods: ['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function profile(): JsonResponse
    {
        return $this->json([
            'user' => $this->getUser()->getEmail(),
            'roles' => $this->getUser()->getRoles()
        ]);
    }
}
