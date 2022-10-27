<?php

namespace App\Repository;

use App\Entity\RefNaemaNew;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RefNaemaNew|null find($id, $lockMode = null, $lockVersion = null)
 * @method RefNaemaNew|null findOneBy(array $criteria, array $orderBy = null)
 * @method RefNaemaNew[]    findAll()
 * @method RefNaemaNew[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RefNaemaNewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RefNaemaNew::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(RefNaemaNew $entity, bool $flush = true): void
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
    public function remove(RefNaemaNew $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

 
    public function findByAll()
    {
        return $this->createQueryBuilder('r')
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?RefNaemaNew
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
