<?php

namespace App\Repository;

use App\Entity\Services;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * @extends ServiceEntityRepository<Services>
 *
 * @method Services|null find($id, $lockMode = null, $lockVersion = null)
 * @method Services|null findOneBy(array $criteria, array $orderBy = null)
 * @method Services[]    findAll()
 * @method Services[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServicesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Services::class);
    }

    public function add(Services $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Services $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function create($dataJson): ?Services
    {
        $name = $dataJson['name']?? throw new BadRequestHttpException('400', null, 400);
        $description = $dataJson['description']?? throw new BadRequestHttpException('400', null, 400);
        $price = $dataJson['price']?? throw new BadRequestHttpException('400', null, 400);
        $active = $dataJson['active']?? throw new BadRequestHttpException('400', null, 400);
        $taxable = $dataJson['taxable']?? throw new BadRequestHttpException('400', null, 400);
        
        $service = new Services();
        $service->setName($name);
        $service->setDescription($description);
        $service->setPrice($price);
        $service->setActive($active);
        $service->setTaxable($taxable);
        $date = new \DateTime();
        $service->setCreatedDate($date);

        return $service;
    }

    public function search($dataJson): ?array
    {
        if(is_null($dataJson)){
            $allServices = $this->findAll();
            return $allServices; 
        }
        $name = isset($dataJson['name']) ? $dataJson['name']:Null;
        $price = isset($dataJson['price']) ? $dataJson['price']:Null ;

        if(!is_null($name) and !is_null($price)){
            $name = strtolower('%'.$name.'%');
            $serviceByNameAndMaxPrice = $this->findByNameAndMaxPrice($name, $price);
            return $serviceByNameAndMaxPrice;
        }
        else{
            if(!is_null($name)){
                $name = strtolower('%'.$name.'%');
                $serviceByName = $this->findByName($name);
                return $serviceByName;
            }
            if(!is_null($price)){
                $serviceByMaxPrice = $this->findByMaxPrice($price);
                return $serviceByMaxPrice;
            }
        }
        if(is_null($name) and is_null($price)){
            $allServicesActive = $this->findByActive();
            return $allServicesActive; 
        }
    }

    /**
    * @return Services[] Returns an array of Services objects
    */
   public function findByName($name): array
   {
       return $this->createQueryBuilder('s')
       ->andWhere('LOWER(s.name) LIKE :name')
       ->andWhere('s.active = true')
       ->setParameter('name', $name)
       ->orderBy('s.id', 'ASC')
       //->setMaxResults(10)
       ->getQuery()
       ->getResult()
        ;
   }

       /**
    * @return Services[] Returns an array of Services objects
    */
    public function findByMaxPrice($priceMax): array
    {
        return $this->createQueryBuilder('s')
        
        ->andWhere('s.price <= :priceMax')
        ->andWhere('s.active = true')
        ->setParameter('priceMax', $priceMax)
        ->orderBy('s.id', 'ASC')
        //->setMaxResults(10)
        ->getQuery()
        ->getResult()
         ;
    }

    /**
    * @return Services[] Returns an array of Services objects
    */
    public function findByNameAndMaxPrice($name, $priceMax): array
    {
        return $this->createQueryBuilder('s')
        ->andWhere('LOWER(s.name) LIKE :name')
        ->andWhere('s.price <= :priceMax')
        ->andWhere('s.active = true')
        ->setParameter('name', $name)
        ->setParameter('priceMax', $priceMax)
        ->orderBy('s.id', 'ASC')
        //->setMaxResults(10)
        ->getQuery()
        ->getResult()
         ;
    }


    /**
    * @return Services[] Returns an array of Services objects
    */
    public function findByDescription($description): array
    {
        return $this->createQueryBuilder('s')
        ->andWhere('LOWER(s.description) LIKE :description')
        ->setParameter('description', $description)
        ->orderBy('s.id', 'ASC')
        //->setMaxResults(10)
        ->getQuery()
        ->getResult()
         ;
    }

       /**
    * @return Services[] Returns an array of Services objects
    */
   public function findByActive(): array
   {
       return $this->createQueryBuilder('s')
       ->andWhere('s.active = true')
       ->orderBy('s.id', 'ASC')
       //->setMaxResults(10)
       ->getQuery()
       ->getResult()
        ;
   }
 
    
//    /**
//     * @return Services[] Returns an array of Services objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Services
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
