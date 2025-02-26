<?php

namespace App\Repository;

use App\Entity\Band;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Band>
 */
class BandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Band::class);
    }

    public function save(Band $band)
    {
        $this->getEntityManager()->persist($band);
        $this->getEntityManager()->flush();
    }

    public function delete(Band $band)
    {
        $this->getEntityManager()->remove($band);
        $this->getEntityManager()->flush();
    }
}
