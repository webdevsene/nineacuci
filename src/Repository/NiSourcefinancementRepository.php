<?php

namespace App\Repository;

use App\Entity\NiSourcefinancement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NiSourcefinancement|null find($id, $lockMode = null, $lockVersion = null)
 * @method NiSourcefinancement|null findOneBy(array $criteria, array $orderBy = null)
 * @method NiSourcefinancement[]    findAll()
 * @method NiSourcefinancement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NiSourcefinancementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NiSourcefinancement::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(NiSourcefinancement $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(NiSourcefinancement $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return NiSourcefinancement[] Returns an array of NiSourcefinancement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NiSourcefinancement
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
