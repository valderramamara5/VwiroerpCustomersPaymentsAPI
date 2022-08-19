<?php

namespace App\Modifier\Create;

use App\Entity\CustomersPhones;
use App\Entity\PhonesNumbers;
use App\Repository\PhonesNumbersRepository;
use App\Repository\CountriesPhoneCodeRepository;
use App\Repository\CountriesRepository;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

class CreatePhone implements CreateInterface
{
    public function __construct(
        private PhonesNumbersRepository $phoneRepository,
        private CountriesRepository $countryRepository,
        private CountriesPhoneCodeRepository $countryPhoneRepository,
        
    ) 
    {}
    public function create($enquire, $object, $wildcard)
    {
        $entityManager = $wildcard->getManager();

        $phoneNumbers = $enquire->getPhoneNumbers();
        $nameCountry = $enquire->getAddress()['Country'];
        $countryId = $this->countryRepository-> findIdByName($nameCountry);
        $countryPhoneCode = $this -> countryPhoneRepository->findOneByCountry($countryId);
        foreach ($phoneNumbers as $phoneNumber){
            $number = $this->phoneRepository->find($phoneNumber);
           
            if(is_null($number)){
                $number = new PhonesNumbers();
                $date = new \DateTime();
                $number->setPhoneNumber($phoneNumber);
                $number->setCountriesPhoneCode($countryPhoneCode);
                $number->setCreatedDate($date);    
                $entityManager->persist($number);
            }
            $customerPhone = new CustomersPhones();
            $date = new \DateTime();
            $customerPhone->setPhonesNumber($number);
            $customerPhone->setCountriesPhoneCode($countryPhoneCode);
            $customerPhone->setCustomers($object);
            $customerPhone->setCreatedDate($date);
            $entityManager->persist($customerPhone);
            
        }
        return "OK";
        
    }
}