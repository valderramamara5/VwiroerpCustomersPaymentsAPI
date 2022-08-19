<?php

namespace App\DTO\ValidateEnquire;

class ValidateIds implements ValidateEnquireInterface
{
    public function validateEnquire($enquire){
        $custType = $enquire->getCustomerType();
        $customerId = $enquire->getIdentification()['value'];
        $idenType = $enquire->getIdentification()['idIdentifierType'];
        if(is_null($custType || $customerId || $idenType)){
            throw new BadRequestHttpException('Customer Ids missing', null, 400);
        }
        else{
            $primaryKeys = ["customerType"=>$custType, "customerId"=>$customerId,"identifierType" => $idenType ];
            return $primaryKeys;
        }
    }
}