<?php

namespace App\Controller;

use App\Entity\Customers;
use App\Entity\CustomersPersonalIdentifications;
use App\Entity\PersonalIdentificationTypes;
use App\Entity\CustomersPhones;
use App\Entity\CustomersAddresses;
use Psr\Log\LoggerInterface;
use App\Entity\Cities;
use App\Entity\CountriesPhoneCode;


use App\Entity\CustomerTypes;
use App\Entity\IdentifierTypes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class CustomersController extends AbstractController
{

    public function list(Request $request, ManagerRegistry $doctrine, LoggerInterface $logger ): Response
    {
        $var = 12;
        $res = $var * 3;
        return $this->json([
            // 'id' => $customer->getId(),
            'path' => 'src/Controller/CustomersController.php',
        ]);
    }
}