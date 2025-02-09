<?php

namespace App\Repository;

use App\Entity\Recette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RecetteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recette::class);
    }

    public function findByPlat(int $idPlat): array
{
    return $this->createQueryBuilder('r')
        ->join('r.plat', 'p')
        ->where('p.id = :idPlat')
        ->setParameter('idPlat', $idPlat)
        ->getQuery()
        ->getResult();
}

}
