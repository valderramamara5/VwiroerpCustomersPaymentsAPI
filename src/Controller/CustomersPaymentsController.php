<?php
namespace App\Controller;

use App\Repository\CustomersRepository;
use App\Repository\ContractsRepository;
use App\Repository\CustomersPaymentsRepository;
use App\Repository\CustomersBalanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CustomersPaymentsController extends AbstractController
{
    public function __construct(private CustomersRepository $customersRepository, private ContractsRepository $contractRepository, private CustomersPaymentsRepository $customersPaymentRepository, private CustomersBalanceRepository $customerBalanceRepository)
    {
    }

    public function recordCustomerPayment(Request $request, ManagerRegistry $doctrine) : Response
    {
        $entityManager = $doctrine->getManager();
        $dataJson = json_decode($request->getContent(), true);
        $validateRequest = $this->customersPaymentRepository->validateRequest($dataJson);
        $customerPayment = $this->customersPaymentRepository->recordPayment($dataJson);
        $entityManager->persist($customerPayment);
        
        $entityManager->flush();
        $customerPaymentId = $customerPayment->getId();
        $response = new JsonResponse();
        $response->setStatusCode(201);
        $response->setContent(json_encode(['CustomerPayment' => $customerPaymentId]));
        
        return $response;
    }
}