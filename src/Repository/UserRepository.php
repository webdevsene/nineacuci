<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

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
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }


    public function findUsersByRoles(string $role1, string $role2)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.roles LIKE :role1 or u.roles LIKE :role2')
           // ->setParameter('role', 'ROLE_%"' . $role1 . '"%')
            ->setParameter('role1', '%"' . $role1 . '"%')
            ->setParameter('role2', '%"' . $role2 . '"%')
            ->getQuery()
            ->getResult();
    }

    public function findUsersByRoles4(string $role1, string $role2, string $role3, string $role4)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.roles LIKE :role1 or u.roles LIKE :role2 or u.roles LIKE :role3 or u.roles LIKE :role4')
           // ->setParameter('role', 'ROLE_%"' . $role1 . '"%')
            ->setParameter('role1', '%"' . $role1 . '"%')
            ->setParameter('role2', '%"' . $role2 . '"%')
            ->setParameter('role3', '%"' . $role3 . '"%')
            ->setParameter('role4', '%"' . $role4 . '"%')
            ->getQuery()
            ->getResult();
    }



            
    public function findNombreUtilisateurParDivision()
    {
        $query= $this->createQueryBuilder('u')
            ->select("count(u.id)");
        return  $query= $query
                 ->getQuery()->getSingleScalarResult()
                ;
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

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
