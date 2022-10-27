<?php

namespace App\Repository;

use App\Entity\RefCategoryCitiNew;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RefCategoryCitiNew|null find($id, $lockMode = null, $lockVersion = null)
 * @method RefCategoryCitiNew|null findOneBy(array $criteria, array $orderBy = null)
 * @method RefCategoryCitiNew[]    findAll()
 * @method RefCategoryCitiNew[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RefCategoryCitiNewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RefCategoryCitiNew::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(RefCategoryCitiNew $entity, bool $flush = true): void
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
    public function remove(RefCategoryCitiNew $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return RefCategoryCitiNew[] Returns an array of RefCategoryCitiNew objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RefCategoryCitiNew
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
