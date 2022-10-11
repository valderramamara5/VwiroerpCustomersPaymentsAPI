<?php

namespace App\Repository;

use App\Entity\ContractServices;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContractServices>
 *
 * @method ContractServices|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContractServices|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContractServices[]    findAll()
 * @method ContractServices[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractServicesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContractServices::class);
    }

    public function add(ContractServices $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ContractServices $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByContract($contract)
    {
        return $this->createQueryBuilder('cs')
            ->join('cs.contracts', 'c')
            ->andWhere('c.id = :id')
            ->setParameter('id',  $contract->getId())
            ->getQuery()
            ->getOneOrNullResult()
    ;
    }

  

//    /**
//     * @return ContractsServices[] Returns an array of ContractsServices objects
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

//    public function findOneBySomeField($value): ?ContractsServices
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
