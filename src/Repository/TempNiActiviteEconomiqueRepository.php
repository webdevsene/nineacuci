<?php

namespace App\Repository;

use App\Entity\TempNiActiviteEconomique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TempNiActiviteEconomique>
 *
 * @method TempNiActiviteEconomique|null find($id, $lockMode = null, $lockVersion = null)
 * @method TempNiActiviteEconomique|null findOneBy(array $criteria, array $orderBy = null)
 * @method TempNiActiviteEconomique[]    findAll()
 * @method TempNiActiviteEconomique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TempNiActiviteEconomiqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TempNiActiviteEconomique::class);
    }

    public function add(TempNiActiviteEconomique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TempNiActiviteEconomique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return TempNiActiviteEconomique[] Returns an array of TempNiActiviteEconomique objects
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

//    public function findOneBySomeField($value): ?TempNiActiviteEconomique
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
