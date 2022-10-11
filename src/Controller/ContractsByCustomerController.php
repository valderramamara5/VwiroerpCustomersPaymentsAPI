<?php
namespace App\Controller;

use App\Repository\CustomersRepository;
use App\Repository\ContractsRepository;
use App\Repository\ContractServicesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ContractsByCustomerController extends AbstractController
{
    public function __construct(private CustomersRepository $customersRepository, private ContractsRepository $contractRepository, private ContractServicesRepository $contractServiceRepository)
    {
    }

    public function getContractsByCustomer(Request $request, ManagerRegistry $doctrine) : Response
    {
        $entityManager = $doctrine->getManager();
        $dataJson = json_decode($request->getContent(), true);
        $customerId=  $dataJson['identification']["value"] ?? throw new BadRequestHttpException('400', null, 400);
        $customerType=  $dataJson['customerType'] ?? throw new BadRequestHttpException('400', null, 400);
        $customerIdentifierType =  $dataJson['identification']['idIdentifierType'] ?? throw new BadRequestHttpException('400', null, 400);
        
        $customer = $this->customersRepository->findById($customerId,$customerType,$customerIdentifierType);
        if(is_null($customer)){
            throw new BadRequestHttpException('400', null, 400);
        }

        $customerName = $this->customersRepository->getName($customer);
        $contracts = $this->contractRepository->findByCustomer($customer);
        $jsonResponse = [];
        foreach ($contracts as $contract) {
            $contractService = $this->contractServiceRepository->findByContract($contract);
            
            $contentResponse = array('NameCustomer' => $customerName, 'ServiceName' => $contractService->getServices()->getName(), 'Price' => $contract->getValue());
            array_push($jsonResponse, $contentResponse);
            
        }
        
        $response = new JsonResponse();
        $response->setContent(json_encode(['CustomerContracts' => $jsonResponse]));
        
        return $response;
    }
}