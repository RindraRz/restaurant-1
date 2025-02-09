<?php 
// src/Entity/Recette.php
namespace App\Entity;

use App\Repository\RecetteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecetteRepository::class)]
class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

  
    #[ORM\ManyToOne(targetEntity: Plat::class, inversedBy: 'recettes')]
    #[ORM\JoinColumn(nullable: false)]
    private $plat;


    #[ORM\ManyToOne(targetEntity: Ingredient::class, inversedBy: 'recettes')]
    #[ORM\JoinColumn(nullable: false)]
    private $ingredient;

    #[ORM\Column(type: 'float')]
    private $quantite;

    // Getters et Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlat(): ?Plat
    {
        return $this->plat;
    }

    public function setPlat(?Plat $plat): self
    {
        $this->plat = $plat;
        return $this;
    }

    public function getIngredient(): ?Ingredient
    {
        return $this->ingredient;
    }

    public function setIngredient(?Ingredient $ingredient): self
    {
        $this->ingredient = $ingredient;
        return $this;
    }

    public function getQuantite(): ?float
    {
        return $this->quantite;
    }

    public function setQuantite(float $quantite): self
    {
        $this->quantite = $quantite;
        return $this;
    }

    public function toArray(): array
{
    return [
        'id' => $this->getId(),
        'plat' => [
            'id' => $this->getPlat()->getId(),
            'nom' => $this->getPlat()->getNom(),
        ],
        'ingredient' => [
            'id' => $this->getIngredient()->getId(),
            'nom' => $this->getIngredient()->getNom(),
            'unit' => $this->getIngredient()->getUnite(),
        ],
        'quantite' => $this->getQuantite(),
    ];
}

}