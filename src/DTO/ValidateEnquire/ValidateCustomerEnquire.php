<?php

namespace App\DTO\ValidateEnquire;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ValidateCustomerEnquire implements ValidateEnquireInterface
{
    public function validateEnquire($enquire){
        $custType = $enquire->getCustomerType();
        $email = $enquire->getEmail();
        
        if(is_null($email)){
            throw new BadRequestHttpException('Customer email missing', null, 400);
        }

        if($custType == 2){
            $comercialName = $enquire->getComercialName();
            if(is_null($comercialName)){
                throw new BadRequestHttpException('Customer comercialName missing', null, 400);
            }
            else{
                return 'OK';
            }
        }
        else{
            $firstName = $enquire->getFirstName();
            $lastName = $enquire->getLastName();
            if(is_null($firstName) || is_null($lastName)){
                throw new BadRequestHttpException('Customer fistName or lastName missing', null, 400);
            }
            else{
                return 'OK';
            }
        } 
    }
}