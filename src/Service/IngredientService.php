<?php
// src/Service/IngredientService.php
namespace App\Service;

use App\Entity\Ingredient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class IngredientService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAllIngredients(): array
    {
        return $this->entityManager->getRepository(Ingredient::class)->findAll();
    }
    
    public function getIngredientById(int $id): Ingredient
    {
        $ingredient = $this->entityManager->getRepository(Ingredient::class)->find($id);
        if (!$ingredient) {
            throw new NotFoundHttpException('Ingrédient non trouvé.');
        }
        return $ingredient;
    }

    public function createIngredient(string $nom, string $unite): Ingredient
    {
        $ingredient = new Ingredient();
        $ingredient->setNom($nom);
        $ingredient->setUnite($unite);

        $this->entityManager->persist($ingredient);
        $this->entityManager->flush();

        return $ingredient;
    }

    public function updateIngredient(int $id, ?string $nom, ?string $unite): Ingredient
    {
       
        $ingredient = $this->getIngredientById($id);

        if ($nom !== null) {
            $ingredient->setNom($nom);
        }
    
       
        if ($unite !== null) {
            $ingredient->setUnite($unite);
        }
    
        $this->entityManager->flush();
    
        return $ingredient;
    }

    public function deleteIngredient(int $id): void
    {
        $ingredient = $this->getIngredientById($id);
        $this->entityManager->remove($ingredient);
        $this->entityManager->flush();
    }
}
