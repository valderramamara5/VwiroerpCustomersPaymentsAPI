<?php

namespace App\Repository;

use App\Entity\CustomersPayments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * @extends ServiceEntityRepository<CustomersPayments>
 *
 * @method CustomersPayments|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomersPayments|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomersPayments[]    findAll()
 * @method CustomersPayments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomersPaymentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomersPayments::class);
    }

    public function add(CustomersPayments $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CustomersPayments $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function recordPayment($dataJson, $customer, $contract): ?CustomersPayments
    {
        $customerPayment = new CustomersPayments();
        $customerPayment->setCustomers($customer);
        $customerPayment->setContracts($contract);
        $paidValue = $dataJson['paid'] ?? throw new BadRequestHttpException('400', null, 400);
        $note = isset($dataJson['note']) ?  $dataJson['note']:Null;
        $customerPayment->setPaidValue($paidValue);
        if($note){
            $customerPayment->setNote($note);
        }

        $date = new \DateTime();
        $customerPayment->setPaymentDate($date);

        return $customerPayment;
    }

//    /**
//     * @return CustomersPayments[] Returns an array of CustomersPayments objects
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

//    public function findOneBySomeField($value): ?CustomersPayments
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
