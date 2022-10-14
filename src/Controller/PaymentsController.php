<?php
namespace App\Controller;


use App\Repository\PaymentsRepository;
use App\Service\RequestValidator\RequestValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PaymentsController extends AbstractController
{
    public function __construct(private RequestValidator $requestValidatorService, private PaymentsRepository $paymentRepository)
    {
    }

    public function recordPayment(Request $request, ManagerRegistry $doctrine) : Response
    {
        $entityManager = $doctrine->getManager();
        $dataJson = json_decode($request->getContent(), true);
        $requestValidator = $this->requestValidatorService->validateRequestRecordPayment($dataJson);
        $payment = $this->paymentRepository->recordPayment($dataJson);
        $entityManager->persist($payment);
        
        $entityManager->flush();
        $paymentId = $payment->getId();
        $response = new JsonResponse();
        $response->setStatusCode(201);
        $response->setContent(json_encode(['PaymentId' => $paymentId]));
        
        return $response;
    }
}