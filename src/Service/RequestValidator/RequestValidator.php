<?php

namespace App\Service\RequestValidator;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
class RequestValidator
{
    public function validateRequestRecordPayment($dataJson)
    {
        $contractId = $dataJson['contractId'] ?? throw new BadRequestHttpException('400', null, 400);
        $userSystem = $dataJson['userSystem']  ?? throw new BadRequestHttpException('400', null, 400);
        $paidValue = $dataJson['paid'] ?? throw new BadRequestHttpException('400', null, 400);
        $methodPayment = $dataJson['methodPayment'] ?? throw new BadRequestHttpException('400', null, 400);
        return 'OK';
    }

}