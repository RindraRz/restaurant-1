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
    

}
