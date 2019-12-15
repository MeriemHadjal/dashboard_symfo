<?php

namespace App\Repository;

use App\Entity\PlanningResponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PlanningResponse|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlanningResponse|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlanningResponse[]    findAll()
 * @method PlanningResponse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanningResponseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlanningResponse::class);
    }

    // /**
    //  * @return PlanningResponse[] Returns an array of PlanningResponse objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PlanningResponse
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
