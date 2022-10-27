<?php

namespace App\Repository;

use App\Entity\RefNomenclatureRc;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RefNomenclatureRc>
 *
 * @method RefNomenclatureRc|null find($id, $lockMode = null, $lockVersion = null)
 * @method RefNomenclatureRc|null findOneBy(array $criteria, array $orderBy = null)
 * @method RefNomenclatureRc[]    findAll()
 * @method RefNomenclatureRc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RefNomenclatureRcRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RefNomenclatureRc::class);
    }

    public function add(RefNomenclatureRc $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RefNomenclatureRc $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return RefNomenclatureRc[] Returns an array of RefNomenclatureRc objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RefNomenclatureRc
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
