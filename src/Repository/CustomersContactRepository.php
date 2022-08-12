<?php

namespace App\Repository;

use App\Entity\CustomersContact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CustomersContact>
 *
 * @method CustomersContact|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomersContact|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomersContact[]    findAll()
 * @method CustomersContact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomersContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomersContact::class);
    }

    public function add(CustomersContact $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CustomersContact $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByCustomers($customer) {
        return $this -> CreateQueryBuilder('cc')
           ->join('cc.customers', 'c')
           ->andwhere('c.id = ?1')
           ->setParameter('1', $customer->getId())
           ->andWhere('c.customerTypes = ?2')
           ->setParameter('2', $customer->getCustomerTypes())
           ->andWhere('c.identifierTypes = ?3')
           ->setParameter('3', $customer->getIdentifierTypes())
           -> getQuery()
           -> getResult();
        ;
         
     }
//    /**
//     * @return CustomersContact[] Returns an array of CustomersContact objects
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

//    public function findOneBySomeField($value): ?CustomersContact
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
