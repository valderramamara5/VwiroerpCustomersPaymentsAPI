<?php
namespace App\Controller;

use App\Repository\ServicesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ServicesController extends AbstractController
{
    public function __construct(private ServicesRepository $serviceRepository)
    {}

    public function create(Request $request, ManagerRegistry $doctrine) : Response
    {
        $entityManager = $doctrine->getManager();
        $dataJson = json_decode($request->getContent(), true);
        $service = $this->serviceRepository->create($dataJson);
        $entityManager->persist($service);
        $entityManager->flush();
        $id = $service->getId();
        $response = new Response();
        $response->setStatusCode(201);
        $response->setContent(json_encode(['idService' => $id])) ;
        return $response;
        // return $this->json([
        //     'path' => 'src/Controller/ServicesController.php',
        // ]);
    }
    

    public function getServices(Request $request, ManagerRegistry $doctrine) : Response
    {
        $entityManager = $doctrine->getManager();
        $dataJson = json_decode($request->getContent(), true);
        $service = $this->serviceRepository->search($dataJson);
        return $this->json([
            'services' => $service,
        ]);        
    }


}