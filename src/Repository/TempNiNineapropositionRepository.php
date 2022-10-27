<?php

namespace App\Repository;

use App\Entity\TempNiNineaproposition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TempNiNineaproposition>
 *
 * @method TempNiNineaproposition|null find($id, $lockMode = null, $lockVersion = null)
 * @method TempNiNineaproposition|null findOneBy(array $criteria, array $orderBy = null)
 * @method TempNiNineaproposition[]    findAll()
 * @method TempNiNineaproposition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TempNiNineapropositionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TempNiNineaproposition::class);
    }

    public function add(TempNiNineaproposition $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TempNiNineaproposition $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return TempNiNineaproposition[] Returns an array of TempNiNineaproposition objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TempNiNineaproposition
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
