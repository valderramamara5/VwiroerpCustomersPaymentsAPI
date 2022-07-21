<?php



namespace App\Controller;

use App\DTO\LowestPriceEnquiry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductsController extends AbstractController
{
    /**
    * @Route("/api/products/{id}/lowest-price", name= "lowest-price", methods={"POST"})
    */
    
    public function lowestPrice(Request $request, int $id, SerializerInterface $serializer): Response
    {


        if ($request -> headers ->has('force_fail')){
            return new JsonResponse(
                ['error' => 'Promotion Engine failure message'], 
                $request -> headers -> get('force_fail') );
            
        }
       
        
       
        
        /**  @var LowestPriceEnquiry $lowestPriceEnquiry */

        $lowestPriceEnquiry = $serializer->deserialize($request-> getContent(), LowestPriceEnquiry::class, 'json');
        
        // $lowestPriceEnquiry = new \App\DTO\LowestPriceEnquiry();
        // $lowestPriceEnquiry -> setPrice(100);
        // $lowestPriceEnquiry -> setDiscountedPrice(50);
        // $lowestPriceEnquiry -> setPromotionId(3);
        // $lowestPriceEnquiry -> setPromotionName('Black friday half price sale');
        
        $json = $serializer->serialize($lowestPriceEnquiry, 'json');
        return new JsonResponse($json, 200) ;
        
        // return new JsonResponse($lowestPriceEnquiry, 200);
        // return $this->json([
        //     // 'id' => $customer->getId(),
        //     'controller' => 'Products',
        // ]);
    }
}
