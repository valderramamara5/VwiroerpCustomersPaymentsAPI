<?php

namespace App\Repository;

use App\Entity\CustomersAddresses;
use App\Repository\CitiesRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CustomersAddresses>
 *
 * @method CustomersAddresses|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomersAddresses|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomersAddresses[]    findAll()
 * @method CustomersAddresses[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomersAddressesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private CitiesRepository $cityRepository)
    {
        parent::__construct($registry, CustomersAddresses::class);
    }

    public function add(CustomersAddresses $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CustomersAddresses $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function create($dataJson, $customer): ?CustomersAddresses
    {
        $address = $dataJson['address'] ?? throw new BadRequestHttpException('400', null, 400);
        $nameCity = $address['city'];
        $city = $this->cityRepository->findByName($nameCity);
        $line1 = $address['line1'];
        $line2 = isset($address['line2']) ? $address['line2']:Null;
        $zipcode = isset($address['zipCode']) ? $address['zipCode']:Null;
        $socioeconomicStatus =  $address['socioeconomicStatus'];
        $note = isset($address['note']) ? $address['note']:Null;
        $date = new \DateTime();
        $customerAddress = new CustomersAddresses();
        $customerAddress->setCustomers($customer);
        $customerAddress->setCities($city);
        $customerAddress->setLine1($line1);
        $customerAddress->setLine2($line2);
        $customerAddress->setZipcode($zipcode);
        $customerAddress->setSocieconomicStatus($socioeconomicStatus);
        $customerAddress->setNote($note);
        $customerAddress->setCreatedDate($date);
        return $customerAddress;
    }

           /**
    * @return CustomersAddresses[] Returns an array of CustomersPhones objects
    */
   public function findByCustomer($customer): array
   {
        return $this->createQueryBuilder('cc')
        ->join('cc.customers', 'c')
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

   public function findOneByCustomer($customer): ?CustomersAddresses
   {
       return $this->createQueryBuilder('ca')
        ->join('ca.customers', 'c')
        ->andWhere('c.id = :id')
        ->andWhere('c.customerTypes = :customerTypes')
        ->andWhere('c.identifierTypes = :identifierTypes')
        ->setParameter('id',  $customer->getId())
        ->setParameter('customerTypes', $customer->getCustomerTypes())
        ->setParameter('identifierTypes', $customer->getIdentifierTypes())
        ->getQuery()
        ->getOneOrNullResult()
       ;
   }

//    /**
//     * @return CustomersAddresses[] Returns an array of CustomersAddresses objects
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

//    public function findOneBySomeField($value): ?CustomersAddresses
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
