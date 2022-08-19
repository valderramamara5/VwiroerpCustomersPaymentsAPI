<?php

namespace App\Modifier\Create;

use App\Entity\CustomerTypes;
use App\Entity\IdentifierTypes;
use App\Entity\Contacts;
use App\Entity\CustomersContact;
use App\Repository\ContactsRepository;
use App\Repository\CustomerTypesRepository;
use App\Repository\IdentifierTypesRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
class CreateContact implements CreateInterface
{
    public function __construct(
        //private CustomersRepository $customersRepository,
        private ContactsRepository $contactRepository,
        private CustomerTypesRepository $customerTRepository,
        private IdentifierTypesRepository $IdentifierRepository,
        
        )
        {}

    public function create($enquire, $object, $wildcard)
    {  
        $mainContact = $enquire->getMainContact();
        $contactId = $mainContact['identification']['value'];
        $identTypeContact = $mainContact['identification']['idIdentifierType'];
        $firstNameContact = $mainContact['firstName'];
        $middleNameContact = isset($mainContact['middleName']) ?$mainContact['middleName']:Null;
        $lastNameContact = $mainContact['lastName'];
        $secondLastNameContact = isset($mainContact['secondLastName']) ? $mainContact['secondLastName']:Null; 
        $emailContact =  $mainContact['email'];

        $contact = $this->contactRepository->findOneByContactIds($contactId,$identTypeContact);
        if(!is_null($contact)){
            throw new BadRequestHttpException('contact already exists', null, 400);
        }
        else{
            $identifierTypeContact = new IdentifierTypes();
            $identifierTypeContact = $this -> IdentifierRepository->find($identTypeContact);
            $contact = new Contacts();
            $contact->setPrimaryKeys($contactId,$identifierTypeContact);
            $contact->setFirstName($firstNameContact);
            $contact->setMiddleName($middleNameContact);
            $contact->setLastName($lastNameContact);
            $contact->setSecondLastName($secondLastNameContact);
            $contact->setEmail($emailContact);
            $date = new \DateTime();
            $contact->setUpdateDate($date);
            $contact->setCreatedDate($date); 

            $customerContacts = new CustomersContact();
            $customerContacts->setCustomers($object);
            $customerContacts -> setContacts($contact);
            
            $contactAndCustomerContact = ['contact'=>$contact,'customerContact' => $customerContacts];

            return $contactAndCustomerContact;
        }
        


    }

}    