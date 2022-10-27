<?php

namespace App\Repository;

use App\Entity\HistoryNiDirigeant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HistoryNiDirigeant>
 *
 * @method HistoryNiDirigeant|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistoryNiDirigeant|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistoryNiDirigeant[]    findAll()
 * @method HistoryNiDirigeant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoryNiDirigeantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistoryNiDirigeant::class);
    }

    public function add(HistoryNiDirigeant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(HistoryNiDirigeant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return HistoryNiDirigeant[] Returns an array of HistoryNiDirigeant objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?HistoryNiDirigeant
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
