<?php

namespace App\DTO\ValidateEnquire;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ValidateReferencesEnquire implements ValidateEnquireInterface
{
    public function validateEnquire($enquire){
        $references = $enquire->getReferences();

        if(is_null($references)){
            throw new BadRequestHttpException('Customer references is not valid', null, 400);
        }

        foreach ($references as $index =>$reference){
            $fullNameReference = isset($reference['fullName']) ? $reference['fullName']:Null;
            $phoneReference = isset($reference['contacPhone']) ? $reference['contacPhone']:Null;
            $idTypeReference = isset($reference['type']) ? $reference['type']:Null;
            if(is_null($fullNameReference) || is_null($phoneReference) || is_null($idTypeReference)){
                throw new BadRequestHttpException('Customer references is not valid', null, 400);
            }
        }

        return "OK";



    }
}