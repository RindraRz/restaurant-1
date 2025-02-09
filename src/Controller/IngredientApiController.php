<?php

namespace App\Controller;

use App\Service\IngredientService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/ingredients')]
class IngredientApiController extends AbstractController
{
    private IngredientService $ingredientService;

    public function __construct(IngredientService $ingredientService)
    {
        $this->ingredientService = $ingredientService;
    }

    #[Route('', methods: ['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(): JsonResponse
    {
        $ingredients = $this->ingredientService->getAllIngredients();
        $data = [];
        foreach ($ingredients as $ingredient) {
            $data[] = $ingredient->toArray();
        }
        return $this->json($data);
    }

    #[Route('/{id}', methods: ['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function show(int $id): JsonResponse
    {
        return $this->json($this->ingredientService->getIngredientById($id));
    }

    #[Route('', methods: ['POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

         return $this->json($this->ingredientService->createIngredient($data["nom"],$data["unite"]));
    }

    #[Route('/{id}', methods: ['PUT'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function update(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $nom = isset($data['nom']) ? $data['nom'] : null;
        $unite = isset($data['unite']) ? $data['unite'] : null;
        $updatedIngredient = $this->ingredientService->updateIngredient($id, $nom, $unite);
        return $this->json($updatedIngredient);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function delete(int $id): JsonResponse
    {
        return $this->json($this->ingredientService->deleteIngredient($id));
    }
}
