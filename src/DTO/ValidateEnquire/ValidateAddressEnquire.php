<?php

namespace App\DTO\ValidateEnquire;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ValidateAddressEnquire implements ValidateEnquireInterface
{
    public function validateEnquire($enquire){

        $address = $enquire->getAddress();
        if(is_null($address)){
            throw new BadRequestHttpException('Customer address is not valid', null, 400);
        }

        $nameCountry = isset($address['Country']) ? $address['Country']:Null;
        $nameState = isset($address['State']) ? $address['State']:Null; 
        $nameCity = isset($address['city']) ? $address['city']:Null;
        if(is_null($nameCountry) || is_null($nameState) || is_null($nameCity)){
            throw new BadRequestHttpException('Select Country, State and City', null, 400);
        }
        //Validar que el estado concuerde con la ciudad de la BD(?)

        $line1 = isset($address['line1']) ? $address['line1']:Null;
        if(is_null($line1)){
            throw new BadRequestHttpException('Customer address is not valid', null, 400);
        }
        $socioeconomicStatus =  isset($address['socioeconomicStatus']) ? $address['socioeconomicStatus']:Null;//Agregar al Json
        if(is_null($socioeconomicStatus)){
            throw new BadRequestHttpException('Select socioeconomicStatus', null, 400);
        }

        return "OK";
        
    
    }
}