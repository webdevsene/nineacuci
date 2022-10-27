<?php

namespace App\Repository;

use App\Entity\DettesCreancesSmtUtil;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DettesCreancesSmtUtil>
 *
 * @method DettesCreancesSmtUtil|null find($id, $lockMode = null, $lockVersion = null)
 * @method DettesCreancesSmtUtil|null findOneBy(array $criteria, array $orderBy = null)
 * @method DettesCreancesSmtUtil[]    findAll()
 * @method DettesCreancesSmtUtil[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DettesCreancesSmtUtilRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DettesCreancesSmtUtil::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(DettesCreancesSmtUtil $entity, bool $flush = true): void
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
    public function remove(DettesCreancesSmtUtil $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return DettesCreancesSmtUtil[] Returns an array of DettesCreancesSmtUtil objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DettesCreancesSmtUtil
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
