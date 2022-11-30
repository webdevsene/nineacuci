<?php

namespace App\Repository;

use App\Entity\DemandeModification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DemandeModification>
 *
 * @method DemandeModification|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemandeModification|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemandeModification[]    findAll()
 * @method DemandeModification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeModificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DemandeModification::class);
    }

    public function add(DemandeModification $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DemandeModification $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DemandeModification[] Returns an array of DemandeModification objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

      public function findBysuiviDemandeModification($user,$value)
      {
        return $this->createQueryBuilder('d')
            ->leftJoin('d.createdBy', 'u')
            ->addSelect('u')
            ->andWhere('u.niAdministration = :administration ')
            ->setParameter('administration', $user->getNiAdministration())
            ->andWhere('d.typeDemande != :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
           
        ;
     }
}
