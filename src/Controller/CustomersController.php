<?php

namespace App\Controller;


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
use App\Repository\ContactsRepository;
use App\Repository\CustomersContactRepository;
use App\Repository\CustomerTypesRepository;
use App\Repository\IdentifierTypesRepository;
use App\Repository\CustomersAddressesRepository;
use App\Repository\PhonesNumbersRepository;
use App\Repository\CustomersPhonesRepository;
use App\Repository\CustomersReferencesRepository;
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

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;



class CustomersController extends AbstractController
{
    public function __construct(
        private CustomersRepository $customersRepository,
        private ContactsRepository $contactRepository,
        private CustomersContactRepository $customerContactRepository,
        private CustomersAddressesRepository $customerAddressRepository,
        private CustomerTypesRepository $customerTRepository,
        private IdentifierTypesRepository $IdentifierRepository,
        private CountriesRepository $countryRepository,
        private CountriesPhoneCodeRepository $countryPhoneRepository,
        private CitiesRepository $cityRepository,
        private StatesRepository $StateRepository,
        private PhonesNumbersRepository $phoneRepository,
        private CustomersPhonesRepository $customerPhoneRepository,
        private CustomersReferencesRepository $customerReferencesRepository,
        private EntityManagerInterface $entityManager
        )
        {}
    
    public function createUpdate(Request $request, ManagerRegistry $doctrine, LoggerInterface $logger) : Response
    {
        
        $this->logger = $logger;
        $this->logger->info("ENTRO");
        $entityManager = $doctrine->getManager();
        $dataJson = json_decode($request->getContent(), true);
 
        $customerId=  $dataJson['identification']["value"] ?? throw new BadRequestHttpException('400', null, 400);
        $customerType=  $dataJson['customerType'] ?? throw new BadRequestHttpException('400', null, 400);
        $customerIdentifierType =  $dataJson['identification']['idIdentifierType'] ?? throw new BadRequestHttpException('400', null, 400);
        
        $customer = $this->customersRepository->findById($customerId,$customerType,$customerIdentifierType);
        
        if(is_null($customer)){
            
            $customer = $this->customersRepository->create($customerId, $customerType, $customerIdentifierType, $dataJson);
            $entityManager->persist($customer);
            
            if($customerType == 2){
                $mainContact = $dataJson['mainContact'] ?? throw new BadRequestHttpException('400', null, 400);
                $contactId = $mainContact['identification']['value'] ?? throw new BadRequestHttpException('400', null, 400);
                $identTypeContact = $mainContact['identification']['idIdentifierType'] ?? throw new BadRequestHttpException('400', null, 400);
                $contact = $this->contactRepository->findById($contactId,$identTypeContact);
                if(is_null($contact)){
                    $contact = $this->contactRepository->create($dataJson);
                    $entityManager->persist($contact);
                }
                $customerContact = $this->customerContactRepository->create($customer, $contact);
                $entityManager->persist($customerContact);
                
            } 

            $customerAddress = $this->customerAddressRepository->create($dataJson, $customer);
            $entityManager->persist($customerAddress);
    
            $phoneNumbers = $dataJson['phoneNumbers'] ?? throw new BadRequestHttpException('400', null, 400);
            $nameCountry = $dataJson['address']['country'] ?? throw new BadRequestHttpException('400', null, 400);
            $countryId = $this->countryRepository-> findIdByName($nameCountry);
            $countryPhoneCode = $this -> countryPhoneRepository->findOneByCountry($countryId);
            foreach ($phoneNumbers as $phoneNumber){
                $number = $this->phoneRepository->find($phoneNumber);
                if(is_null($number)){
                    $number = $this->phoneRepository->create($phoneNumber, $countryPhoneCode);
                    $entityManager->persist($number);
            }
            $customerPhone = $this->customerPhoneRepository->create($number, $countryPhoneCode, $customer);
            $entityManager->persist($customerPhone);
            }
            

            $references = $dataJson['references'] ?? throw new BadRequestHttpException('400', null, 400);
            
            foreach($references as $reference){
                $customerReference = $this->customerReferencesRepository->create($reference, $customer, $countryPhoneCode);
                $entityManager->persist($customerReference);
            }

            $entityManager->flush();  
            return $this->json([
                'path' => 'src/Controller/CustomersController.php',
            ]);
            

            
        
    }


        else
        {
            //Agregar updates para el customer ingresado
            return $this->json([
                'path' => 'src/Controller/CustomersController.php',
            ]); 

        }
        

       
        
    }
}