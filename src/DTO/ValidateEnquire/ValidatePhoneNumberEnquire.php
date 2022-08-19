<?php

namespace App\DTO\ValidateEnquire;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ValidatePhoneNumberEnquire implements ValidateEnquireInterface
{
    public function validateEnquire($enquire){
    
        $phoneNumbers = $enquire->getPhoneNumbers();

        if(is_null($phoneNumbers) || count($phoneNumbers) == 0 ){
            throw new BadRequestHttpException('Customer phone is not valid', null, 400);
        }

        foreach($phoneNumbers as $phoneNumber){
            if(strlen($phoneNumber)<7 || strlen($phoneNumber)>14 || gettype($phoneNumber)!= "string") {
                throw new BadRequestHttpException('Customer phone is not valid', null, 400);
            }
        }
        return "OK";
    }

}