<?php

namespace App\Service\RequestValidator;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
class RequestValidator
{
    public function validateRequestContractsByCustomer($dataJson)
    {
        $customerId=  $dataJson['identification']["value"] ?? throw new BadRequestHttpException('400', null, 400);
        $customerType=  $dataJson['customerType'] ?? throw new BadRequestHttpException('400', null, 400);
        $customerIdentifierType =  $dataJson['identification']['idIdentifierType'] ?? throw new BadRequestHttpException('400', null, 400);
        return 'OK';
    }
}