<?php
// src/Controller/Api/PlatApiController.php
namespace App\Controller;

use App\Service\PlatService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/plats', name: 'api_plat_')]
class PlatApiController extends AbstractController
{
    private PlatService $platService;
    private SerializerInterface $serializer;

    public function __construct(PlatService $platService, SerializerInterface $serializer)
    {
        $this->platService = $platService;
        $this->serializer = $serializer;
    }

    // CREATE
    #[Route('', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $plat = $this->platService->createPlat($data['nom'], $data['cusineTime'], $data['prix']);

        return $this->json($plat, JsonResponse::HTTP_CREATED);
    }

    // READ (one plat)
    #[Route('/{id}', methods: ['GET'])]
    public function getPlat(int $id): JsonResponse
    {
        $plat = $this->platService->getPlat($id);

        if (!$plat) {
            return $this->json(['message' => 'Plat not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->json($plat->toArray());
    }

    // UPDATE
    #[Route('/{id}', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            $plat = $this->platService->updatePlat($id, $data['nom'] ?? null, $data['cusineTime'] ?? null, $data['prix'] ?? null);
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->json($plat);
    }

    // DELETE
    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        try {
            $this->platService->deletePlat($id);
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->json(['message' => 'Plat deleted successfully']);
    }

    // READ (all plats)
    #[Route('', methods: ['GET'])]
    public function getAllPlats(): JsonResponse
    {
        $plats = $this->platService->getAllPlats();
        $data = [];
        foreach ($plats as $plat) {
            $data[] = $plat->toArray();
        }
        return $this->json($data);
    }
}
