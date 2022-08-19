<?php

namespace App\Modifier\Create;

use App\Entity\CustomersAddresses;
use App\Entity\States;
use App\Repository\CitiesRepository;
use App\Repository\StatesRepository;

class CreateAddress implements CreateInterface
{
    public function __construct(
        private CitiesRepository $cityRepository,
        private StatesRepository $StateRepository
    )
    {}

    public function create($enquire, $object, $wildcard = Null)
    {
        //$nameCountry = isset($address['Country']) ? $address['Country']:Null;
        //$nameState = isset($address['State']) ? $address['State']:Null; 
        $address = $enquire->getAddress();
        $nameCity = $address['city'];
        $city = $this->cityRepository->findByName($nameCity);
        $line1 = $address['line1'];
        $line2 = isset($address['line2']) ? $address['line2']:Null;
        $zipcode = isset($address['zipCode']) ? $address['zipCode']:Null;
        $socioeconomicStatus =  $address['socioeconomicStatus'];
        $note = isset($address['note']) ? $address['note']:Null;
        $date = new \DateTime();
        $customerAddress = new CustomersAddresses();
        $customerAddress->setCustomers($object);
        $customerAddress->setCities($city);
        $customerAddress->setLine1($line1);
        $customerAddress->setLine2($line2);
        $customerAddress->setZipcode($zipcode);
        $customerAddress->setSocieconomicStatus($socioeconomicStatus);
        $customerAddress->setNote($note);
        $customerAddress->setCreatedDate($date);
        return $customerAddress;

    }
}