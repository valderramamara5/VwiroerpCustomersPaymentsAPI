<?php

namespace App\Repository;

use App\Entity\CustomersBalance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CustomersBalance>
 *
 * @method CustomersBalance|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomersBalance|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomersBalance[]    findAll()
 * @method CustomersBalance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomersBalanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomersBalance::class);
    }

    public function add(CustomersBalance $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CustomersBalance $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function updateCustomerBalance($customerPayment, $customerBalance)
    {
        
        $customerBalance->setCustomersPayments($customerPayment);
        $paidValue = $customerPayment->getPaidValue();
        $balance = $customerBalance->getBalance();
        $newBalance = $balance -= $paidValue; 
        $customerBalance->setBalance($newBalance);
        $customerBalance->setLastPaidValue($paidValue);
        $paymentDate = $customerPayment->getPaymentDate();
        $customerBalance->setLastPaymentDate($paymentDate);
        return $customerBalance;
    }

       public function findOneByCustomerAndContract($customer, $contract): ?CustomersBalance
   {
       return $this->createQueryBuilder('cb')
           ->join('cb.customers', 'c')
           ->join('cb.contracts', 'ctr')
           ->andWhere('c.id = :customerId')
           ->andWhere('c.customerTypes = :customerType')
           ->andWhere('c.identifierTypes = :customerIdentifierType')
           ->andWhere('ctr.id = :contractId')
           ->setParameter('customerId', $customer->getId())
           ->setParameter('customerType', $customer->getCustomerTypes())
           ->setParameter('customerIdentifierType', $customer->getIdentifierTypes())
           ->setParameter('contractId', $contract->getId())
           ->getQuery()
           ->getOneOrNullResult()
       ;
   }

//    /**
//     * @return CustomersBalance[] Returns an array of CustomersBalance objects
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

//    public function findOneBySomeField($value): ?CustomersBalance
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
