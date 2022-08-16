<?php

namespace App\Controller;

use App\Entity\Customers;
use App\Entity\CustomersPersonalIdentifications;
use App\Entity\PersonalIdentificationTypes;
use App\Entity\CustomersPhones;
use App\Entity\CustomersAddresses;
use App\Entity\Cities;
use App\Entity\Contacts;
use App\Entity\CountriesPhoneCode;
use App\Entity\CustomerTypes;
use App\Entity\IdentifierTypes;
use App\Entity\CustomersContact; 
use App\Entity\Countries;
use App\Entity\States;
use App\Entity\CustomersReferences;
use App\Repository\CustomersRepository;
//use App\Repository\CustomersContactRepository;
use App\Repository\CustomerTypesRepository;
use App\Repository\IdentifierTypesRepository;
use App\Repository\CountriesRepository;
use App\Repository\CountriesPhoneCodeRepository;
use App\Repository\CitiesRepository;
use App\Repository\StatesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;

class CustomersController extends AbstractController
{
    public function __construct(
        private CustomersRepository $customersRepository,
        //private PromotionRepository $repositoryPromotion
        private CustomerTypesRepository $customerTRepository,
        private IdentifierTypesRepository $IdentifierRepository,
        //private CustomersContactRepository $customerContactRepository,
        private CountriesRepository $countryRepository,
        private CountriesPhoneCodeRepository $countryPhoneRepository,
        private CitiesRepository $cityRepository,
        private StatesRepository $StateRepository,
        private EntityManagerInterface $entityManager
        )
        {}
    

   
    public function create(Request $request, ManagerRegistry $doctrine, LoggerInterface $logger) : Response
    {
        $this->logger = $logger;

        $this->logger->info("ENTRO");

  
        $entityManager = $doctrine->getManager();

        $dataJson = json_decode($request->getContent(), true);
        
        $conn = $entityManager -> getConnection(); 
        
        
        $idenType = $dataJson['identification']['idIdentifierType'];
        $custType = $dataJson['customerType'];
        $customerId = $dataJson['identification']['value'];
        $emailCustomer = $dataJson['email'];
    
        // $firstNameCustomer = 'maria';
        // $middleNameCustomer = 'lucia'; Agregar al Json
        // $lastNameCustomer  = 'perez';
        // $emailCustomer = '@1';
        
        

       
        $nameCountry = 'Colombia'; //Agregar al Json
        
        $countryId = $this->countryRepository-> findIdByName($nameCountry);
        $country =  $this->countryRepository-> findByName($nameCountry);
        $countryPhoneCode = $this -> countryPhoneRepository->findOneByCountry($countryId);

        $phoneNumbers =$dataJson['phoneNumbers'];

        
        $nameState = 'Valle del Cauca'; //Agregar al Json
        
        $nameCity = $dataJson['address']['city']['name'];
        $line1 = $dataJson['address']['line1'];
        $line2 = $dataJson['address']['line2'];;
        $zipcode = $dataJson['address']['zipCode'];

        $socioconomicStatus = 5; //Agregar al Json
        
        $note = $dataJson['address']['note'];
        //$states = $this->StateRepository->findByName($nameState);
        $city =  $this->cityRepository->findByName($nameCity);
     
        
        $references = $dataJson['references'];

        $customerType = new CustomerTypes;
        $identifierType = new IdentifierTypes();
        $customer = new Customers();


        $identifierType = $this -> IdentifierRepository ->find($idenType);
        $customerType = $this ->customerTRepository ->find($custType);
        $customer->setPrimaryKeys($customerId, $customerType, $identifierType); 
        $customer->setEmail(isset($emailCustomer) ? $emailCustomer : Null);
        
 
        $date = new \DateTime();
        $customer->setCreatedDate($date);
        $customer->setUpdateDate($date);
       
       
        if($custType == 2){
            $comercialName = $dataJson['comercialName'];
            $contactId = '65456545785'; //Agregar al Json(?)
            $identTypeContact = 1; //Agregar al Json(?)
            $firstNameContact = $dataJson['mainContact']['firstName'];
            $middleNameContact = $dataJson['mainContact']['middleName'];
            $lastNameContact  =  $dataJson['mainContact']['lastName'];
            $secondLastNameContact = $dataJson['mainContact']['secondLastName'];
            $emailContact =  $dataJson['mainContact']['email'];
            
            $customer->setComercialName($comercialName);
            $entityManager->persist($customer);
            //$identifierTypeContact = new IdentifierTypes();
            $contact = new Contacts();
            
            $identifierTypeContact = $this -> IdentifierRepository ->find($identTypeContact);
            
            $contact->setPrimaryKeys($contactId,$identifierTypeContact);
            $contact->setFirstName($firstNameContact);
            $contact->setMiddleName(isset($middleNameContact) ? $middleNameContact : Null);
            $contact->setLastName($lastNameContact);
            $contact->setSecondLastName(isset($secondLastNameContact) ? $secondLastNameContact : Null);
            $contact->setEmail($emailContact);
            $contact->setUpdateDate($date);
            $contact->setCreatedDate($date);   
            $entityManager->persist($contact);
            
            
            $customersContacts = new CustomersContact();
            $customersContacts->setCustomers($customer);
            $customersContacts -> setContacts($contact);
            $entityManager->persist($customersContacts);

            
        }
        else{
            $firstNameCustomer = $dataJson['firstName'];
            
            $middleNameCustomer = isset($dataJson['middleName']) ? $dataJson['middleName']:Null; //Agregar al Json
            
            $lastNameCustomer = $dataJson['lastName'];

            $customer-> setFirstName($firstNameCustomer);
            $customer-> setMiddleName($middleNameCustomer);
            $customer-> setLastName($lastNameCustomer);
            $customer-> setSecondLastName(isset($secondLastNameCustomer) ? $secondLastNameCustomer : Null);
            $entityManager->persist($customer);
       
        }     

        foreach($phoneNumbers as $number){
            $customerPhone = new CustomersPhones();
            $customerPhone->setPhoneNumber($number);
            $customerPhone->setCustomers($customer);
            $customerPhone->setCountriesPhoneCode($countryPhoneCode);
            $customerPhone->setCreatedDate($date);
           
            $entityManager->persist($customerPhone);

        }

        $customerAddress = new CustomersAddresses();
        $customerAddress->setCustomers($customer);
        $customerAddress->setCities($city);
        $customerAddress->setLine1($line1);
        $customerAddress->setLine2($line2);
        $customerAddress->setZipcode($zipcode);
        $customerAddress->setSocieconomicStatus($socioconomicStatus);
        $customerAddress->setNote($note);
        $customerAddress->setCreatedDate($date);
       
        $entityManager->persist($customerAddress);
        
      

        
        foreach($references as $reference){
            $customerReference = new CustomersReferences();
            $referenceIdentifierType = new IdentifierTypes();
            $referenceIdentifierType = $this -> IdentifierRepository ->find($reference['type']);
            $customerReference->setCustomers($customer);
            $customerReference->setReferencesCountriesPhoneCode($countryPhoneCode);
            $customerReference->setFullName($reference['fullName']);
            $customerReference->setReferencesContactPhone($reference['contacPhone']);
            $customerReference->setCreatedDate($date);
            $entityManager->persist($customerReference);
          
          
        }
        
        
        $entityManager->flush();  
        return $this->json([
            //'id' => $customerType->getId(),
            'customer' => $customer,
            // 'contact' => $customersContacts,
            //'address' => $customerAddress,
            // 'phone' => $customerPhone,
            // 'customerReference' => $customerReference,
            //'customerPhone' => $customerPhone,
             //'type' => $customersContacts->getCustomers(),
             'path' => 'src/Controller/CustomersController.php',
         ]); 
        

 

    }


    public function update(Request $request, ManagerRegistry $doctrine, LoggerInterface $logger) : Response
    {
        $this->logger = $logger;

        $this->logger->info("ENTRO");

  
        $entityManager = $doctrine->getManager();

        $dataJson = json_decode($request->getContent(), true);
        
        $conn = $entityManager -> getConnection(); 

        return $this->json([
            'infoUpdate' => $customer,
             'path' => 'src/Controller/CustomersController.php',
         ]); 
        
    }    
        

}