<?php

namespace App\DTO\ValidateEnquire;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ValidateContactEnquire implements ValidateEnquireInterface
{
    public function validateEnquire($enquire){

        $mainContact = $enquire->getMainContact();
        if(is_null($mainContact)){
            throw new BadRequestHttpException('mainContact missing', null, 400);
        }


        $identificationContact = isset($mainContact['identification']) ?$mainContact['identification'] : Null;
        if(is_null($identificationContact)){
            throw new BadRequestHttpException('IdentificationContact missing', null, 400);
        }

        $contactId = isset($mainContact['identification']['value']) ? $mainContact['identification']['value']: Null;

        $identTypeContact = isset($mainContact['identification']['idIdentifierType']) ? $mainContact['identification']['idIdentifierType']: Null;
        if(is_null($contactId) || is_null($identTypeContact)){
            throw new BadRequestHttpException('IdentificationContact missing', null, 400);
        }

        $firstNameContact = isset($mainContact['firstName']) ? $mainContact['firstName']: Null;
        $lastNameContact = isset($mainContact['lastName']) ? $mainContact['lastName']: Null;
       
        if(is_null($firstNameContact) || is_null($lastNameContact)){
            throw new BadRequestHttpException('firstNameContact or lastNameContact missing', null, 400);
        }

        $emailContact =  $mainContact['email'];
        if(is_null($emailContact)){
            throw new BadRequestHttpException('mainContact email missing ', null, 400);
        }

        return "OK";
    }
}