<?php

namespace App\Modifier\Update;

use App\Entity\Customers;
use App\Entity\CustomerTypes;
use App\Entity\IdentifierTypes;
use App\Repository\CustomersRepository;
use App\Repository\CustomerTypesRepository;
use App\Repository\IdentifierTypesRepository;

use Doctrine\ORM\EntityManagerInterface;

class UpdateCustomer implements UpdateInterface
{
    public function __construct(
        private CustomersRepository $customersRepository,
        private CustomerTypesRepository $customerTRepository,
        private IdentifierTypesRepository $IdentifierRepository,
        private EntityManagerInterface $entityManager
        )
        {}
    public function update($object, $enquire, $wildcard)
    {
        $entityManager = $wildcard->getManager();
        $custType = $enquire->getCustomerType();
        $email = $enquire->getEmail();
        $comercialName = $enquire->getComercialName();
        $firstName = $enquire->getFirstName();
        $middleName = $enquire->getMiddleName();
        $lastName = $enquire->getLastName();
        $secondLastName = $enquire->getSecondLastName();

        if (!is_null($email)){   
            $object->setEmail($email);
            $date = new \DateTime();
            $object->setUpdateDate($date);  
            $entityManager->persist($object); 
        }

        if($custType == 2 ){
            if (!is_null($comercialName)){
                $object->setComercialName($comercialName);
                $date = new \DateTime();
                $object->setUpdateDate($date);
                $entityManager->persist($object);
            }
        }

        else{
            if (!is_null($firstNameCustomer)){
                $object->setFirstName($firstNameCustomer);
            }
            if (!is_null($middleNameCustomer)){
                $object->setMiddleName($middleNameCustomer);
            } 
            if (!is_null($lastNameCustomer)){
                $object->setLastName($lastNameCustomer);
            }
            if (!is_null($secondLastNameCustomer)){
                $object->setSecondLastName($secondLastNameCustomer);
            }
            $date = new \DateTime();
            $object->setUpdateDate($date);
            $entityManager->persist($object);
        }    
        return $object;
    }
}