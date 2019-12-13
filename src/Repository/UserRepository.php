<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

  
    public function findAllEmailFromUserToPlanning($value): ?Array
    {

        // SELECT `email`
        // FROM `user`
        // LEFT JOIN `enfants`  ON user.id = enfants.user_id
        // LEFT JOIN `equipe` ON equipe.id = enfants.equipe_id 
        // LEFT JOIN `equipe_planning` ON equipe_planning.equipe_id = equipe.id
        // LEFT JOIN `planning` ON equipe_planning.planning_id = planning.id 
        // WHERE `planning`.id = 3; 

        return $this->createQueryBuilder('u')
            ->select('u.email')
            ->leftJoin('u.enfants', 'e')
            // 'e' est un alias de enfants
            ->leftJoin('e.equipe', 'eq')
            ->leftJoin('eq.planning', 'p')
            ->andWhere('p.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }
 
}
