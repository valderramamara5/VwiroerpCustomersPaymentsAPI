<?php
namespace App\Controller;

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
use Doctrine\Persistence\ManagerRegistry;
//use Doctrine\DBAL\Connection;
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
        private IdentifierTypesRepository $identifierRepository,
        private CountriesRepository $countryRepository,
        private CountriesPhoneCodeRepository $countryPhoneRepository,
        private CitiesRepository $cityRepository,
        private StatesRepository $stateRepository,
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
        else{
            $customer = $this->customersRepository->update($customer, $dataJson);
            $entityManager->persist($customer);
            if($customerType == 2){
                $mainContact = isset($dataJson['mainContact']) ? $dataJson['mainContact']:Null;
                if (!is_null($mainContact)){
                    $customerContact = $this->customerContactRepository->findOneByCustomer($customer);
                    $contact = $customerContact->getContacts();
                    $contact = $this->contactRepository->update($dataJson, $contact);
                    $customerContact = $this->customerContactRepository->update($contact, $customerContact);
                    $entityManager->persist($customerContact);
                    $entityManager->persist($contact);
                }
            }

            $address =isset($dataJson['address']) ? $dataJson['address']:Null;
            if(!is_null($address)){
                $customerAddress = $this->customerAddressRepository->findOneByCustomer($customer);
                $customerAddress = $this->customerAddressRepository->update($dataJson, $customerAddress);
                $entityManager->persist($customerAddress);  
            }

            $phoneNumbers = $dataJson['phoneNumbers'] ? $dataJson['phoneNumbers']:Null;
            if(!is_null($phoneNumbers)){
                foreach ($phoneNumbers as $phoneNumber){
                    $customerCity = $this->customerAddressRepository->findOneByCustomer($customer);
                    $nameCountry = $customerCity->getCities()->getStates()->getCountries()->getName();
                    $countryId = $this->countryRepository-> findIdByName($nameCountry);
                    $countryPhoneCode = $this->countryPhoneRepository->findOneByCountry($countryId);

                    $number = $this->phoneRepository->find($phoneNumber);
                    if(is_null($number)){
                        $number = $this->phoneRepository->create($phoneNumber, $countryPhoneCode);
                        $entityManager->persist($number);
                    }
                    $customerPhones =  $this->customerPhoneRepository->findByCustomer($customer);
                    foreach($customerPhones as $customerPhone){
                        if($customerPhone->getPhonesNumber()!=$number){
                            $newCustomerPhone = $this->customerPhoneRepository->create($number, $countryPhoneCode, $customer);
                            $entityManager->persist($newCustomerPhone);
                        }
                    }
                }  
            }

            $references = $dataJson['references'] ? $dataJson['references']:Null;
            if(!is_null($references)){
                $customerReferences = $this->customerReferencesRepository->findByCustomer($customer);
                
                foreach($references as $reference){
                    foreach($customerReferences as $customerReference){
                        if(($customerReference->getFullName()== $reference['fullName']) and ($customerReference->getReferencesContactPhone()== $reference['contactPhone'])){
                            continue;
                        }
                        else{
                            $newCustomerReference = $this->customerReferencesRepository->create($reference, $customer, $countryPhoneCode);
                            $entityManager->persist($newCustomerReference);
                        }
                    }
                }
            }
            $entityManager->flush();  
            return $this->json([
                'path' => 'src/Controller/CustomersController.php',
            ]); 
        }      
    }
}