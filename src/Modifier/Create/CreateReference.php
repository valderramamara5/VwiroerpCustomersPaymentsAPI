<?php

namespace App\Modifier\Create;
use App\Entity\CustomersReferences;
use App\Repository\PhonesNumbersRepository;
use App\Repository\CountriesPhoneCodeRepository;
use App\Repository\CountriesRepository;
use App\Repository\IdentifierTypesRepository;

class CreateReference implements CreateInterface
{
    public function __construct(
        private PhonesNumbersRepository $phoneRepository,
        private CountriesRepository $countryRepository,
        private CountriesPhoneCodeRepository $countryPhoneRepository,
        private IdentifierTypesRepository $IdentifierRepository,
        
        
    )
    {}
    public function create($enquire, $object, $wildcard)
    {
        $entityManager = $wildcard->getManager();
        $references = $enquire->getReferences();
        $nameCountry = $enquire->getAddress()['Country'];
        $countryId = $this->countryRepository-> findIdByName($nameCountry);
        $countryPhoneCode = $this -> countryPhoneRepository->findOneByCountry($countryId);

        foreach($references as $reference){
            $fullNameReference = $reference['fullName'];
            $phoneReference = $reference['contacPhone'];
            $idTypeReference = $reference['type'];
            $identifierTypeReference = $this -> IdentifierRepository->find($idTypeReference);
            $customerReference = new CustomersReferences();
            $date = new \DateTime();
            $customerReference->setCustomers($object);
            $customerReference->setReferencesIdentifierTypes($identifierTypeReference);
            $customerReference->setFullName($fullNameReference);
            $customerReference->setReferencesContactPhone($phoneReference);
            $customerReference->setReferencesCountriesPhoneCode($countryPhoneCode);
            $customerReference->setCreatedDate($date);
            $entityManager->persist($customerReference);
            
    
        }
     
    }

}