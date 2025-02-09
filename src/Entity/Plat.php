<?php 
// src/Entity/Plat.php
namespace App\Entity;

use App\Repository\PlatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlatRepository::class)]
class Plat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $nom;

    #[ORM\Column(type: 'integer')]
    private $cusineTime;

    #[ORM\Column(type: 'float')]
    private $prix;

  
    #[ORM\OneToMany(targetEntity: Recette::class, mappedBy: 'plat')]
    private $recettes;

    #[ORM\OneToMany(targetEntity: Vente::class, mappedBy: 'plat')]
    private $ventes;

    public function __construct()
    {
        $this->recettes = new ArrayCollection();
        $this->ventes = new ArrayCollection();
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

    public function getCusineTime(): ?int
    {
        return $this->cusineTime;
    }

    public function setCusineTime(int $cusineTime): self
    {
        $this->cusineTime = $cusineTime;
        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;
        return $this;
    }

    /**
     * @return Collection|Recette[]
     */
    public function getRecettes(): Collection
    {
        return $this->recettes;
    }

    /**
     * @return Collection|Vente[]
     */
    public function getVentes(): Collection
    {
        return $this->ventes;
    }
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'nom' => $this->getNom(),
            'cusineTime' => $this->getCusineTime(),
           'prix' => $this->getPrix()
        ];
    }
}