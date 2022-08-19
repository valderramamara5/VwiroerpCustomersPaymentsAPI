<?php

namespace App\Modifier\Create;

use App\Entity\Customers;
use App\Entity\CustomerTypes;
use App\Entity\IdentifierTypes;
use App\Repository\CustomersRepository;
use App\Repository\CustomerTypesRepository;
use App\Repository\IdentifierTypesRepository;

use Doctrine\ORM\EntityManagerInterface;

class CreateCustomer {
    public function __construct(
        private CustomersRepository $customersRepository,
        private CustomerTypesRepository $customerTRepository,
        private IdentifierTypesRepository $IdentifierRepository,
        private EntityManagerInterface $entityManager
        )
        {}
    public function create($customerId, $customerType, $customerIdentifierType, $dataJson )
    {

        $email = $dataJson['email'] ?? throw new BadRequestHttpException('400', null, 400);

        $customer = new Customers();
        $customerType = new CustomerTypes;
        $identifierType = new IdentifierTypes();
        
        $identifierType = $this -> IdentifierRepository->find($idenType);
        $customerType = $this ->customerTRepository->find($custType);
        $customer->setPrimaryKeys($customerId, $customerType, $identifierType);
        
        $date = new \DateTime();
        $customer->setCreatedDate($date);
        $customer->setUpdateDate($date);

        $customer->setEmail($email);

        if ($custType == 2){
            $comercialName = $dataJson['comercialName'] ?? throw new BadRequestHttpException('400', null, 400);
            $customer->setComercialName($comercialName);
        }
        else{
            $firstName = $dataJson['firstName'] ?? throw new BadRequestHttpException('400', null, 400);
            $middleName = $dataJson['middleName'] ;
            $lastName = $dataJson['lastName'] ?? throw new BadRequestHttpException('400', null, 400);;
            $secondLastName = $dataJson['secondLastName'] ;
            $customer->setFirstName($firstName);
            $customer->setMiddleName($middleName);
            $customer->setLastName($lastName);
            $customer->setSecondLastName($secondLastName);
        }
        
        return $customer;
    }
}