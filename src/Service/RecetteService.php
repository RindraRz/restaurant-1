<?php

namespace App\Service;

use App\Entity\Recette;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;

class RecetteService
{
    private $recetteRepository;
    private $entityManager;

    public function __construct(RecetteRepository $recetteRepository, EntityManagerInterface $entityManager)
    {
        $this->recetteRepository = $recetteRepository;
        $this->entityManager = $entityManager;
    }

    // Créer une recette
    public function createRecette($plat, $ingredient, $quantite): Recette
    {
        $recette = new Recette();
        $recette->setPlat($plat);
        $recette->setIngredient($ingredient);
        $recette->setQuantite($quantite);

        $this->entityManager->persist($recette);
        $this->entityManager->flush();

        return $recette;
    }

    // Récupérer une recette par son ID
    public function getRecette(int $id): ?Recette
    {
        return $this->recetteRepository->find($id);
    }

    // Mettre à jour une recette
    public function updateRecette(int $id, $plat = null, $ingredient = null, $quantite = null): Recette
    {
        $recette = $this->getRecette($id);
        if (!$recette) {
            throw new \Exception("Recette not found");
        }

        if ($plat) {
            $recette->setPlat($plat);
        }
        if ($ingredient) {
            $recette->setIngredient($ingredient);
        }
        if ($quantite) {
            $recette->setQuantite($quantite);
        }

        $this->entityManager->flush();

        return $recette;
    }

    // Supprimer une recette
    public function deleteRecette(int $id)
    {
        $recette = $this->getRecette($id);
        if (!$recette) {
            throw new \Exception("Recette not found");
        }

        $this->entityManager->remove($recette);
        $this->entityManager->flush();
    }

    // Récupérer toutes les recettes
    public function getAllRecettes()
    {
        return $this->recetteRepository->findAll();
    }

     // Récupérer une recette par Id plat
     public function getAllRecettesByPlat(int $idPlat): array
     {
         $recettes = $this->recetteRepository->findByPlat($idPlat);
 
         $data = [];
         foreach ($recettes as $recette) {
             $data[] = $recette->toArray();
         }
 
         return $data;
     }
     
}
