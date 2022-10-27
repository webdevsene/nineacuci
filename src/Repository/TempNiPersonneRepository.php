<?php

namespace App\Repository;

use App\Entity\TempNiPersonne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TempNiPersonne>
 *
 * @method TempNiPersonne|null find($id, $lockMode = null, $lockVersion = null)
 * @method TempNiPersonne|null findOneBy(array $criteria, array $orderBy = null)
 * @method TempNiPersonne[]    findAll()
 * @method TempNiPersonne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TempNiPersonneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TempNiPersonne::class);
    }

    public function add(TempNiPersonne $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TempNiPersonne $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return TempNiPersonne[] Returns an array of TempNiPersonne objects
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

//    public function findOneBySomeField($value): ?TempNiPersonne
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
