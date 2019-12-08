<?php

namespace App\Repository;

use App\Entity\Enfants;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Enfants|null find($id, $lockMode = null, $lockVersion = null)
 * @method Enfants|null findOneBy(array $criteria, array $orderBy = null)
 * @method Enfants[]    findAll()
 * @method Enfants[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnfantsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Enfants::class);
    }

    // /**
    //  * @return Enfants[] Returns an array of Enfants objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Enfants
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
