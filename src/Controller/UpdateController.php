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
use App\Repository\ContactsRepository;

use App\Repository\CustomersContactRepository;
use App\Repository\CustomerTypesRepository;
use App\Repository\IdentifierTypesRepository;
use App\Repository\CountriesRepository;
use App\Repository\CountriesPhoneCodeRepository;
use App\Repository\CitiesRepository;
use App\Repository\StatesRepository;
use App\Repository\CustomersPhonesRepository;
use App\Repository\CustomersAddressesRepository;
use App\Repository\CustomersReferencesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;

class UpdateController extends AbstractController
{
    public function __construct(
        private CustomersRepository $customersRepository,
        //private PromotionRepository $repositoryPromotion
        private CustomerTypesRepository $customerTRepository,
        private IdentifierTypesRepository $IdentifierRepository,
        private CustomersContactRepository $customerContactRepository,
        private CountriesRepository $countryRepository,
        private CountriesPhoneCodeRepository $countryPhoneRepository,
        private CitiesRepository $cityRepository,
        private StatesRepository $StateRepository,
        private ContactsRepository $contactRepository,
        private CustomersPhonesRepository $customerPhonesRepository,
        private CustomersAddressesRepository $customerAddressRepository,
        private CustomersReferencesRepository $customerReferenceRepository,
        private EntityManagerInterface $entityManager
        )
        {}


    public function update(Request $request, ManagerRegistry $doctrine, LoggerInterface $logger) : Response
    {
        $this->logger = $logger;

        $this->logger->info("ENTRO");

        $entityManager = $doctrine->getManager();

        $dataJson = json_decode($request->getContent(), true);
        
        $conn = $entityManager -> getConnection(); 

        $customerId = $dataJson['identification']['value'];
        $custType = $dataJson['customerType'];
        $idenType = $dataJson['identification']['idIdentifierType'];
        // $customerType = $this->customerTRepository->findOneById($custType);
        // $identifierCustomerType = $this->IdentifierRepository->find($idenType);
        $customer = new Customers();
        //$customer = $this->customersRepository->findByPrimaryKeys($customerId,$custType,$idenType);
        dd($customer);
        // $customer = $this->customersRepository->findByPrimaryKeys($customerId,$customerType,$identifierCustomerType);
       
        
                 
        if(!is_null($customer)){
            
            $email = isset($dataJson['email']) ? $dataJson['email']: Null;
            if (!is_null($email)){   
                $customer->setEmail($email);
                $date = new \DateTime();
                $customer->setUpdateDate($date);
               // $customer->setId(44444444444444);
                
                $entityManager->persist($customer);
              
            }
            
            if($custType == 2){
                
                $comercialName = $dataJson['comercialName'] ? $dataJson['comercialName']: Null;
                if (!is_null($comercialName)){
                    $customer->setComercialName($comercialName);
                    $date = new \DateTime();
                    $customer->setUpdateDate($date);
                    $entityManager->persist($customer);
                }

                $mainContact = isset($dataJson['mainContact']) ? $dataJson['mainContact']:Null;
                if (!is_null($mainContact)){
                   
                    $customerContact = $this->customerContactRepository->findOneByCustomer($customer);
                    $contact = $customerContact->getContacts();
                    
                    $idContact = isset($dataJson['mainContact']['id']) ? $dataJson['mainContact']['id']:Null;
                    if (!is_null($idContact)){
                        $contact->setId($idContact);
                        $date = new \DateTime();
                        $contact->setUpdateDate($date);
                        $customerContact->setContacts($contact);
                    } 
                    
                    $identTypeContact = isset($dataJson['mainContact']['identifierType']) ? $dataJson['mainContact']['identifierType']:Null;
                    if (!is_null($identTypeContact)){
                        $contact->setIdentifierTypes($identTypeContact);
                        $date = new \DateTime();
                        $contact->setUpdateDate($date);
                        $customerContact->setContact($contact);
                    }

                    $firstNameContact = isset($dataJson['mainContact']['firstName']) ? $dataJson['mainContact']['firstName']:Null;
                    if (!is_null($firstNameContact)){
                        $contact->setFirstName($firstNameContact);
                        $date = new \DateTime();
                        $contact->setUpdateDate($date);
                    }
                    
                    $middleNameContact = isset($dataJson['mainContact']['middleName']) ?$dataJson['mainContact']['middleName']:Null;
                    if (!is_null($middleNameContact)){
                        $contact->setMiddleName($middleNameContact);
                        $date = new \DateTime();
                        $contact->setUpdateDate($date);
                    }

                    $lastNameContact  =  isset($dataJson['mainContact']['lastName']) ?$dataJson['mainContact']['lastName']:Null ;
                    if (!is_null($lastNameContact)){
                        $date = new \DateTime();
                        $contact->setUpdateDate($date);
                        $contact->setLastName($lastNameContact);
                    }    

                    $secondLastNameContact = isset($dataJson['mainContact']['secondLastName']) ? $dataJson['mainContact']['secondLastName']:Null;
                    if (!is_null($secondLastNameContact)){
                        $date = new \DateTime();
                        $contact->setUpdateDate($date);
                        $contact->setSecondLastName($secondLastNameContact);
                    }
                    
                    $emailContact =  isset($dataJson['mainContact']['email']) ? $dataJson['mainContact']['email']:Null;
                    if (!is_null($emailContact)){
                        $date = new \DateTime();
                        $contact->setUpdateDate($date);
                        $contact->setEmail($emailContact);
                    }  
                    $entityManager->persist($contact);
                    $entityManager->persist($customerContact);
                }

            }
            else{
                $firstNameCustomer = isset($dataJson['firstName']) ? $dataJson['firstName'] : Null;
                if (!is_null($firstNameCustomer)){
                    $customer->setFirstName($firstNameCustomer);
                }

                $middleNameCustomer = isset($dataJson['middleName']) ? $dataJson['middleName']:Null;
                if (!is_null($middleNameCustomer)){
                    $customer->setMiddleName($middleNameCustomer);
                } 

                $lastNameCustomer = isset($dataJson['lastName']) ? $dataJson['lastName']:Null;
                if (!is_null($lastNameCustomer)){
                    $customer->setLastName($lastNameCustomer);
                }
                $secondLastNameCustomer = isset($dataJson['secondLastName']) ? $dataJson['secondLastName']:Null;

                if (!is_null($secondLastNameCustomer)){
                    $customer->setSecondLastName($secondLastNameCustomer);
                }
                $date = new \DateTime();
                $customer->setUpdateDate($date);
                $entityManager->persist($customer);
            } 
            
            $phoneNumbers =isset($dataJson['phoneNumbers']) ? $dataJson['phoneNumbers']:Null;

            if (!is_null($phoneNumbers)){
                $customerPhones = $this->customerPhonesRepository->findByCustomer($customer);
                foreach($phoneNumbers as $index => $number){
                    $customerPhones[$index]->setPhoneNumber($number);
                    //$customerPhone[$index]->setCountriesPhoneCode($countryPhoneCode);
                    $entityManager->persist($customerPhones[$index]);
                }
            }

            $address =isset($dataJson['address']) ? $dataJson['address']:Null;
            if(!is_null($address)){
                $customerAddress = $this->customerAddressRepository->findOneByCustomer($customer);
            
                $city = isset($dataJson['address']['city']['name']) ? $dataJson['address']['city']['name']:Null;
                $cityCustomer = $this->cityRepository->findByName($city);
                if (!is_null($cityCustomer)){
                    $customerAddress->setCities($cityCustomer);
                    $entityManager->persist($customerAddress);
                }

                $line1 = isset($dataJson['address']['line1']) ? $dataJson['address']['line1']:Null;
                if (!is_null($line1)){
                    $customerAddress->setLine1($line1);
                    $entityManager->persist($customerAddress);
                }
                
                $line2 = isset($dataJson['address']['line2']) ? $dataJson['address']['line2']:Null;
                if (!is_null($line2)){
                    $customerAddress->setLine2($line2);
                    $entityManager->persist($customerAddress);
                }
                
                $zipcode = isset($dataJson['address']['zipcode']) ? $dataJson['address']['zipcode']:Null;
                if (!is_null($zipcode)){
                    $customerAddress->setZipcode($zipcode);
                    $entityManager->persist($customerAddress);
                }

                $socioeconomicStatus = isset($dataJson['address']['socioconomicStatus']) ? $dataJson['address']['socioconomicStatus']:Null;
                if (!is_null($socioconomicStatus)){
                    $customerAddress->setSocieconomicStatus($socioconomicStatus);
                    $entityManager->persist($customerAddress);
                }
            
                $note = isset($dataJson['address']['note']) ? $dataJson['address']['note']:Null;
                if (!is_null($note)){
                    $customerAddress->setNote($note);
                    $entityManager->persist($customerAddress);
                }
            }
            
            $references =isset($dataJson['references']) ? $dataJson['references']:Null;
            if(!is_null($references)){
                $customerReference = $this->customerReferenceRepository->findByCustomer($customer);
                foreach($references as $index =>$reference){
                    $referenceIdType = isset($dataJson['references'][$index]['type']) ? $dataJson['references'][$index]['type']:Null;
                    if(!is_null($referenceIdType)){
                        $referenceIdentifierType = $this -> IdentifierRepository ->find($referenceIdType);
                        $customerReference[$index]->setReferencesIdentifierTypes($referenceIdentifierType);
                        $entityManager->persist( $customerReference[$index]);
                    }

                    $fullName = isset($dataJson['references'][$index]['fullName']) ? $dataJson['references'][$index]['fullName']:Null;
                    if(!is_null($fullName)){
                        $customerReference[$index]->setFullName($fullName);
                        $entityManager->persist($customerReference[$index]);
                    }

                    $contactPhone = isset($dataJson['references'][$index]['contactPhone']) ? $dataJson['references'][$index]['contactPhone']:Null;
                    if(!is_null($contactPhone)){
                        $customerReference[$index]->setReferencesContactPhone($contactPhone);
                        $entityManager->persist($customerReference[$index]);
                    }     
                }
            }

            
            return $this->json([
                'infoCUpdate' => $customer,
                'infoPUpdate' => $customerPhones,
                'infoAUpdate' =>$customerAddress,
                'infoRUpdate' =>$customerReference,
                'path' => 'src/Controller/CustomersController.php',
            ]);

            
            $entityManager->flush();  
        }  
    }

}    