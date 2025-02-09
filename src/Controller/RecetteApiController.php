<?php

namespace App\Controller;

use App\Service\RecetteService;
use App\Entity\Plat;
use App\Entity\Ingredient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/api/recettes', name: 'api_recette_')]
class RecetteApiController extends AbstractController
{
    private RecetteService $recetteService;
    private EntityManagerInterface $entityManager;

    public function __construct(RecetteService $recetteService, EntityManagerInterface $entityManager)
    {
        $this->recetteService = $recetteService;
        $this->entityManager = $entityManager;
    }

    // CREATE
    #[Route('', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validation des données
        $plat = $this->entityManager->getRepository(Plat::class)->find($data['platId']);
        $ingredient = $this->entityManager->getRepository(Ingredient::class)->find($data['ingredientId']);

        if (!$plat || !$ingredient) {
            return $this->json(['message' => 'Plat or Ingredient not found'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $recette = $this->recetteService->createRecette($plat, $ingredient, $data['quantite']);

        return $this->json($recette->toArray(), JsonResponse::HTTP_CREATED);
    }

    // READ (one recette)
    #[Route('/{id}', methods: ['GET'])]
    public function getRecette(int $id): JsonResponse
    {
        $recette = $this->recetteService->getRecette($id);

        if (!$recette) {
            return $this->json(['message' => 'Recette not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->json($recette->toArray());
    }

    // UPDATE
    #[Route('/{id}', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validation des données
        $plat = $this->entityManager->getRepository(Plat::class)->find($data['platId'] ?? null);
        $ingredient = $this->entityManager->getRepository(Ingredient::class)->find($data['ingredientId'] ?? null);

        try {
            $recette = $this->recetteService->updateRecette($id, $plat, $ingredient, $data['quantite'] ?? null);
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->json($recette->toArray());
    }

    // DELETE
    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        try {
            $this->recetteService->deleteRecette($id);
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->json(['message' => 'Recette deleted successfully']);
    }

    // READ (all recettes)
    #[Route('', methods: ['GET'])]
    public function getAllRecettes(): JsonResponse
    {
        $recettes = $this->recetteService->getAllRecettes();
       
        $data = [];
        foreach ($recettes as $recette) {
            $data[] = $recette->toArray();
        }
        return $this->json($data);
    }

    #[Route('/plat/{idPlat}', methods: ['GET'])]
    public function getRecettesByPlat(int $idPlat): JsonResponse
    {
        $data = $this->recetteService->getAllRecettesByPlat($idPlat);
        return $this->json($data);
    }
}
