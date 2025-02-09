<?php
// src/Service/PlatService.php
namespace App\Service;

use App\Entity\Plat;
use App\Repository\PlatRepository;
use Doctrine\ORM\EntityManagerInterface;

class PlatService
{
    private $platRepository;
    private $entityManager;

    public function __construct(PlatRepository $platRepository, EntityManagerInterface $entityManager)
    {
        $this->platRepository = $platRepository;
        $this->entityManager = $entityManager;
    }

    // CREATE
    public function createPlat(string $nom, int $cusineTime, float $prix): Plat
    {
        $plat = new Plat();
        $plat->setNom($nom);
        $plat->setCusineTime($cusineTime);
        $plat->setPrix($prix);

        $this->entityManager->persist($plat);
        $this->entityManager->flush();

        return $plat;
    }

    // READ
    public function getPlat(int $id): ?Plat
    {
        return $this->platRepository->find($id);
    }

    // UPDATE
    public function updatePlat(int $id, ?string $nom, ?int $cusineTime, ?float $prix): Plat
    {
        $plat = $this->getPlat($id);

        if (!$plat) {
            throw new \Exception('Plat not found');
        }

        if ($nom) {
            $plat->setNom($nom);
        }
        if ($cusineTime) {
            $plat->setCusineTime($cusineTime);
        }
        if ($prix) {
            $plat->setPrix($prix);
        }

        $this->entityManager->flush();

        return $plat;
    }

    // DELETE
    public function deletePlat(int $id): void
    {
        $plat = $this->getPlat($id);

        if (!$plat) {
            throw new \Exception('Plat not found');
        }

        $this->entityManager->remove($plat);
        $this->entityManager->flush();
    }

    // GET ALL
    public function getAllPlats(): array
    {
        return $this->platRepository->findAll();
    }
}
