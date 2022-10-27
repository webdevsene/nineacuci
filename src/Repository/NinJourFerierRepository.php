<?php

namespace App\Repository;

use App\Entity\NinJourFerier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NinJourFerier>
 *
 * @method NinJourFerier|null find($id, $lockMode = null, $lockVersion = null)
 * @method NinJourFerier|null findOneBy(array $criteria, array $orderBy = null)
 * @method NinJourFerier[]    findAll()
 * @method NinJourFerier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NinJourFerierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NinJourFerier::class);
    }

    public function add(NinJourFerier $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(NinJourFerier $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return NinJourFerier[] Returns an array of NinJourFerier objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?NinJourFerier
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
