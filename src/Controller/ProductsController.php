<?php



namespace App\Controller;

use App\Cache\PromotionCache;
use App\DTO\LowestPriceEnquiry;
use App\Filter\PromotionFilterInterface;
use App\Repository\ProductRepository;
use App\Service\Serializer\DTOSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Promotion;
use App\Entity\Product;
use App\Repository\PromotionRepository;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class ProductsController extends AbstractController
{

    public function __construct(
        private ProductRepository $repository,
        //private PromotionRepository $repositoryPromotion
        private EntityManagerInterface $entityManager
        )
    {
        
    }
    /**
    * @Route("/api/products/{id}/lowest-price", name= "lowest-price", methods={"POST"})
    */
    
    public function lowestPrice(
        Request $request,
        int $id, 
        DTOSerializer $serializer,
        PromotionFilterInterface $promotionFilter, 
        PromotionCache $promotionCache
        ): Response
    {

        if ($request -> headers ->has('force_fail')){
            return new JsonResponse(
                ['error' => 'Promotion Engine failure message'], 
                $request -> headers -> get('force_fail') );     
        }

        /**  @var LowestPriceEnquiry $lowestPriceEnquiry */

        $lowestPriceEnquiry = $serializer->deserialize($request-> getContent(), LowestPriceEnquiry::class, 'json');

        $product = $this -> repository -> find($id); //Add error for not found product
        $lowestPriceEnquiry -> setProduct($product);

        // $promotions = $this -> repositoryPromotion -> findValidForProduct(
        //     $product, date_create_immutable($lowestPriceEnquiry -> getRequestDate()) 
        // );

       
        $promotions = $promotionCache -> findValidForProduct($product, $lowestPriceEnquiry -> getRequestDate());

                
        
        $modifiedEnquiry = $promotionFilter -> apply($lowestPriceEnquiry, ...$promotions);
        
        $responseContent = $serializer->serialize($modifiedEnquiry, 'json');
        return new Response($responseContent, 200, ['Content-Type' => 'application/json']);
       
    }
}
