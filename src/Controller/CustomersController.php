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
use App\Entity\ReferencesCustomers;
use App\Repository\CustomersRepository;
use App\Repository\CustomersContactRepository;
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
        private CustomersContactRepository $customerContactRepository,
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

        // //$dataJson = json_decode($request->getContent(), true);
        
        $conn = $entityManager -> getConnection(); 
       
       
        // $customer = new Customers();
        // $customerType = $this ->customerTRepository ->find(1);
        // $identifierType = $this -> IdentifierRepository ->find(1);
        // //dd($customer ->setId('123'));
        // $customer ->  setPrimaryKeys('132', $customerType, $identifierType);

        // dd($customer);
        
        // $customers = $this -> customersRepository -> findAll();
        // $customer1 = $this -> customersRepository -> findById($customers[0]);
        
        // $customer2 = $this -> customersRepository -> findCostumersById('23');
        // dd($customer2);
        
        // $customerTypes = $this -> customerTRepository -> findAll();

        // foreach ($customers as $custumer3){
        // $customer4 = $this -> customersRepository -> findByCustomerTypes($custumer3);
        // }
        // dd($customer2);
        
        // //dd($customers[0]);

    
        // // $customer = $this ->customersRepository->find($customers[0]);
        // // dd($customer);   
        
        // //dd($customer);
        // //$customer = $this -> customersRepository->find($customer->getId());
        // //dd($customer);
        // //$customers = $this -> customerContactRepository -> findAll();
        // $customerTypes = $this -> customerTRepository -> findAll();
        // //dd($customerTypes);
        // $customers[0] -> setCustomerTypes($customerTypes[4]);
        // //dd($customers[0]);
       
        // $customerContact = $this -> customerContactRepository -> findByCustomers($customers[0]);
        // //dd($customerContact);
        
        // $customers[0] -> setCustomerTypes($customerTypes[0]);
        // $customerContact[0]->setCustomers($customers[0]);
        // dd($customerContact[0]);
        
        //$customerContact = $this ->customerContactRepository ->find([1]);
        //$customerContact = $this -> customerContactRepository->findAll();
        //$identifierType = $entityManager->getRepository(IdentifierTypes::class)->find(1);
        



        //$customers = $this ->customerContactRepository ->find(1);
       
        //dd($customers);

        $idenType = 1;
        $custType = 2;
        $customerId = '5657';
        $firstNameCustomer = 'maria';
        $middleNameCustomer = 'lucia';
        $lastNameCustomer  = 'perez';
        $emailCustomer = '@1';
        
        $comercialName = 'Consured';
        $contactId = '9890';
        $identTypeContact = 1;
        $firstNameContact = 'susana';
        $lastNameContact  =  'garcia';
        $emailContact =  '@2';

        //$country = new Countries();
        $nameCountry = 'Colombia';
        $countryId = $this->countryRepository-> findIdByName($nameCountry);
        $country =  $this->countryRepository-> findByName($nameCountry);
        $countryPhoneCode = $this -> countryPhoneRepository->findOneByCountry($countryId);

        $phoneNumbers =[
            "7868671476",
            "2675519215"
        ];

        
        $nameState = 'Valle del Cauca';
        $nameCity = 'Jamundí';
        $line1 = "20515 E Country Club DR";
        $line2 = "Apto 346";
        $zipcode = 33180;
        $socioconomicStatus = 5;
        $note = "Al lado de la iglesia";
        //$states = $this->StateRepository->findByName($nameState);
        $city =  $this->cityRepository->findByName($nameCity);
        //dd($states, $city);
        //$countryPhoneCode = $this -> countryPhoneRepository->findOneByCountry($countryId);

        $references = [([
            "fullName" =>'Pepe Lopez',
            "contactPhone"=>"7868672314",
            "type"=>1]),
            (["fullName"=>'Pepa Lopez',
            "contactPhone"=>"7868672314",
            "type"=>1])
        ];
        
    

        $customerType = new CustomerTypes;
        $identifierType = new IdentifierTypes();
        $customer = new Customers();
        //$contact = new Contacts();
        
        
        //$entityManager->persist($customerTypes);
        //$entityManager->flush();
        //$customersContacts = new CustomersContact();

        $identifierType = $this -> IdentifierRepository ->find($idenType);
        $customerType = $this ->customerTRepository ->find($custType);
        $customer->setPrimaryKeys($customerId, $customerType, $identifierType); 
        $customer->setEmail(isset($emailCustomer) ? $emailCustomer : Null);
        
 
        //$customerId = $customer->getId();
        $date = new \DateTime();
        $customer->setCreatedDate($date);
        $customer->setUpdateDate($date);
        //$customer->setEmail($email);

       
        if($custType == 2){
            
            $customer->setComercialName($comercialName);
            $entityManager->persist($customer);
            $identifierTypeContact = new IdentifierTypes();
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
            $customer-> setFirstName($firstNameCustomer);
            $customer-> setMiddleName(isset($middleNameCustomer) ? $middleNameCustomer : Null);
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
            $customerReference = new ReferencesCustomers();
            $referenceIdentifierType = new IdentifierTypes();
            $referenceIdentifierType = $this -> IdentifierRepository ->find($reference['type']);
            $customerReference->setCustomers($customer);
            $customerReference->setReferencesCountriesPhoneCode($countryPhoneCode);
            $customerReference->setFullName($reference['fullName']);
            $customerReference->setReferencesContactPhone($reference['contactPhone']);
            $customerReference->setCreatedDate($date);
            $entityManager->persist($customerReference);
          
          
        }
        
        $entityManager->flush();  
        
        return $this->json([
                //'id' => $customerType->getId(),
                'customerReference' => $customerReference,
                //'customerPhone' => $customerPhone,
                 //'type' => $customersContacts->getCustomers(),
                 'path' => 'src/Controller/CustomersController.php',
             ]); 

        $entityManager->flush();  
        // $identifierType = $entityManager->getRepository(IdentifierTypes::class)->find(1);
 
        return $this->json([
           'id' => $customerType->getId(),
           'customer' => $customer,
           'customerPhone' => $customerPhone,
            //'type' => $customersContacts->getCustomers(),
            'path' => 'src/Controller/CustomersController.php',
        ]);  

        
        // $customer = new Customers();
        // $customerTypes = new CustomerTypes;

        // $contacts = new CustomersContact();
        // $customerTypes = $entityManager->getRepository(CustomerTypes::class)->find($dataJson['customerType']);
        // $identifierType = $entityManager->getRepository(IdentifierTypes::class)->find($dataJson['identification']['idIdentifierType']);
        



        // $customer->setPrimaryKeys($dataJson['identification']['value'],$customerTypes,$identifierType);
        
        // if ($dataJson['customerType'] == 2) {
        //     $customer->setComercialName($dataJson['comercialName']);
        //     $customer->setFirstName($dataJson['mainContact']['firstName']);
        //     $customer->setLastName($dataJson['mainContact']['lastName']);
        //     $customer->setMiddleName(isset($dataJson['mainContact']['middleName']) ? $dataJson['mainContact']['middleName'] : Null);
        // } else {
        //     $customer->setFirstName($dataJson['firstName']);
        //     $customer->setLastName($dataJson['lastName']);
        //     $customer->setMiddleName(isset($dataJson['middleName']) ? $dataJson['middleName'] : Null);
        //     // $customer->setMotherSurname(isset($dataJson['motherSurname']) ? $dataJson['motherSurname'] : Null); Cambiar a la nueva proiedad
        // }
        
        // $date = new \DateTime();
        // $customer->setCreatedDate($date);
        // $customer->setEmail(isset($dataJson['email']) ? $dataJson['email'] : Null);
        // // $entityManager->persist($customer);
        // // $entityManager->flush();
       
        
        

        // $countryPhoneCode = new CountriesPhoneCode();
        // $countryPhoneCode = $entityManager->getRepository(CountriesPhoneCode::class)->find(1);
        // foreach ($dataJson['phoneNumbers'] as $number) {
        //     $date = new \DateTime();
        //     $phone = new CustomersPhones();
        //     $phone->setIdCustomerPhoneNumber($customer, $number);
        //     $phone->setIdCountriesPhoneCode($countryPhoneCode);
        //     $phone->setCreatedDate($date);
        //     $entityManager->persist($phone);  
        // }
        

        // $address = new  CustomersAddresses();
        // //$address->setIdCustomers($customer->getId()); en SetIdCustomersAdress
        // $address->setLine1($dataJson['address']['line1']);
        // $address->setLine2($dataJson['address']['line2']);
        // $address->setZipcode($dataJson['address']['zipCode']);
        // $address->setSocioeconomicStatus($dataJson['address']['socioconomicStatus']);
        // $address->setNote($dataJson['address']['note']);
        // $address->setCreatedDate($date);
        // $date = new \DateTime();
        // $address->setIdCustomersAddress($customer);
        
        // //my_version_entity_Cities_db c.id_states_id in github id_states db c.id_states
        // $sqlCities = "SELECT * FROM cities c WHERE c.id_states_id = :idstates AND c.name = :name";
        // $stmt = $conn->prepare($sqlCities);
        // $nameCity = $dataJson['address']['city']['name'];
        // $idState = $dataJson['address']['city']['state']['id'];

        // $this->logger->info("Name city to save:". $nameCity);
        // $resultSet = $stmt->executeQuery(['idstates' => $idState, 'name' => $nameCity]);
        // $cities = $resultSet->fetchAllAssociative();
        // ;
        // if($cities <> false){
        //     $city = $entityManager->getRepository(Cities::class)->find($cities[0]['id']);
        //     $address->setIdCities($city);
        //     $this->logger->info("CITY:". $cities[0]['id']);
        // }
        // $this->logger->info("Num records match with state and city name:". count($cities));
        // $this->logger->info("CITY ID:". json_encode($cities));

        // $entityManager->persist($address);

        

        
        




    
    }    

}