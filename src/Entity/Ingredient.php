<?php 
// src/Entity/Ingredient.php
namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $nom;

    #[ORM\Column(type: 'string', length: 10)]
    private $unite;

    #[ORM\OneToMany(targetEntity: StockIngredient::class, mappedBy: 'ingredient')]
    private $stockIngredients;

   
    #[ORM\OneToMany(targetEntity: Recette::class, mappedBy: 'ingredient')]
    #[Ignore]
    private $recettes;

    public function __construct()
    {
        $this->stockIngredients = new ArrayCollection();
        $this->recettes = new ArrayCollection();
    }

    // Getters et Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getUnite(): ?string
    {
        return $this->unite;
    }

    public function setUnite(string $unite): self
    {
        $this->unite = $unite;
        return $this;
    }

    /**
     * @return Collection|StockIngredient[]
     */
    public function getStockIngredients(): Collection
    {
        return $this->stockIngredients;
    }

    /**
     * @return Collection|Recette[]
     */
    public function getRecettes(): Collection
    {
        return $this->recettes;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'nom' => $this->getNom(),
            'unite' => $this->getUnite(),
           
        ];
    }
}