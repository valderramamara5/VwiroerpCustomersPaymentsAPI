<?php

namespace App\Repository;

use App\Entity\Contracts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contracts>
 *
 * @method Contracts|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contracts|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contracts[]    findAll()
 * @method Contracts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contracts::class);
    }

    public function add(Contracts $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Contracts $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return Contracts[] Returns an array of Contracts objects
    */
   public function findByCustomer($customer): array
   {
        return $this->createQueryBuilder('ct')
            ->join('ct.customers', 'c')
            ->andWhere('c.id = :id')
            ->andWhere('c.customerTypes = :customerTypes')
            ->andWhere('c.identifierTypes = :identifierTypes')
            ->setParameter('id',  $customer->getId())
            ->setParameter('customerTypes', $customer->getCustomerTypes())
            ->setParameter('identifierTypes', $customer->getIdentifierTypes())
            ->getQuery()
            ->getResult()
    ;
   }
   
//    /**
//     * @return Contracts[] Returns an array of Contracts objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Contracts
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
