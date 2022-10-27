<?php

namespace App\Repository;

use App\Entity\HistoryNiActiviteEconomique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HistoryNiActiviteEconomique>
 *
 * @method HistoryNiActiviteEconomique|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistoryNiActiviteEconomique|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistoryNiActiviteEconomique[]    findAll()
 * @method HistoryNiActiviteEconomique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoryNiActiviteEconomiqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistoryNiActiviteEconomique::class);
    }

    public function add(HistoryNiActiviteEconomique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(HistoryNiActiviteEconomique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return HistoryNiActiviteEconomique[] Returns an array of HistoryNiActiviteEconomique objects
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

//    public function findOneBySomeField($value): ?HistoryNiActiviteEconomique
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
