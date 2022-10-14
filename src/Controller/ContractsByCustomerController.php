<?php
namespace App\Controller;


use App\Repository\ContractsRepository;
use App\Service\RequestValidator\RequestValidator;

use App\Repository\ContractServicesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ContractsByCustomerController extends AbstractController
{
    public function __construct(private RequestValidator $requestValidatorService, private ContractsRepository $contractRepository, private ContractServicesRepository $contractServiceRepository)
    {
    }

    public function getContractsByCustomer(Request $request, ManagerRegistry $doctrine) : Response
    {
        $entityManager = $doctrine->getManager();
        $dataJson = json_decode($request->getContent(), true);
        $requestValidator = $this->requestValidatorService->validateRequestContractsByCustomer($dataJson);
        $customerId=  $dataJson['identification']["value"];
        $customerType=  $dataJson['customerType'];
        $customerIdentifierType =  $dataJson['identification']['idIdentifierType'];
        dd($requestValidator);
        
        // $customer = $this->customersRepository->findById($customerId,$customerType,$customerIdentifierType);
        // if(is_null($customer)){
        //     throw new BadRequestHttpException('400', null, 400);
        // }

        //$customerName = $this->customersRepository->getName($customer);
        $contracts = $this->contractRepository->findByCustomer($customerId, $customerType, $customerIdentifierType);
        $jsonResponse = [];
        foreach ($contracts as $contract) {
            $contractService = $this->contractServiceRepository->findByContract($contract);
            
            $contentResponse = array('CustomerName' => $customerName, 'IdContract' => $contract->getId(), 'ServiceName' => $contractService->getServices()->getName(), 'Price' => $contract->getValue());
            array_push($jsonResponse, $contentResponse);
            
        }
        
        $response = new JsonResponse();
        $response->setContent(json_encode(['CustomerContracts' => $jsonResponse]));
        
        return $response;
    }
}