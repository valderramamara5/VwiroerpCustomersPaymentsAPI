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

    public function validateRequest($dataJson)
    {
        $contractId = $dataJson['contractId'] ?? throw new BadRequestHttpException('400', null, 400);
        $userSystem = $dataJson['userSystem']  ?? throw new BadRequestHttpException('400', null, 400);
        $paidValue = $dataJson['paid'] ?? throw new BadRequestHttpException('400', null, 400);
        $methodPayment = $dataJson['methodPayment'] ?? throw new BadRequestHttpException('400', null, 400);
        return 'OK';
    }

    public function recordPayment($dataJson): ?CustomersPayments
    {
        $contractId = $dataJson['contractId'];
        $userSystem = $dataJson['userSystem'];
        $paidValue = $dataJson['paid'];
        $methodPayment = $dataJson['methodPayment'];
        $note = isset($dataJson['note']) ?  $dataJson['note']:Null;
        $customerPayment = new CustomersPayments();
        $customerPayment->setContractsId($contractId);
        $customerPayment->setUserSystem($userSystem);
        $customerPayment->setPaidValue($paidValue);
        $customerPayment->setMethodPayment($methodPayment);
        $customerPayment->setNote($note);
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
