<?php 
// src/Entity/StockIngredient.php
namespace App\Entity;

use App\Repository\StockIngredientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockIngredientRepository::class)]
class StockIngredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Ingredient::class, inversedBy: 'stockIngredients')]
    #[ORM\JoinColumn(nullable: false)]
    private $ingredient;

    #[ORM\Column(type: 'float')]
    private $quantite;

    // Getters et Setters
    public function getId(): ?int
    {
        return $this->id;
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
}