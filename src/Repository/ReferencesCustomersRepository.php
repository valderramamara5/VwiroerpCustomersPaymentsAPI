<?php

namespace App\Repository;

use App\Entity\ReferencesCustomers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReferencesCustomers>
 *
 * @method ReferencesCustomers|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReferencesCustomers|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReferencesCustomers[]    findAll()
 * @method ReferencesCustomers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReferencesCustomersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReferencesCustomers::class);
    }

    public function add(ReferencesCustomers $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ReferencesCustomers $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ReferencesCustomers[] Returns an array of ReferencesCustomers objects
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

//    public function findOneBySomeField($value): ?ReferencesCustomers
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
