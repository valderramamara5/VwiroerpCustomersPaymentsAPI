<?php
namespace App\Filter;


use App\Filter\PromotionFilterInterface;
use App\DTO\PromotionEnquiryInterface;
use App\Entity\Product;
use App\Entity\Promotion;
use App\DTO\LowestPriceEnquiry;
use App\Filter\Modifier\Factory\PriceModifierFactoryInterface;
use App\Filter\Modifier\Factory\PriceModifierFactory;
use App\DTO\PriceEnquiryInterface;

class LowestPriceFilter implements PriceFilterInterface
{
    public function __construct(private PriceModifierFactoryInterface $priceModifierFactory)
    {
       
    }

    public function apply(PriceEnquiryInterface $enquiry, Promotion ...$promotions): PriceEnquiryInterface
    {

        
        $price = $enquiry -> getProduct() -> getPrice();
        $quantity  = $enquiry -> getQuantity();
        $enquiry -> setPrice($price);
        $lowestPrice = $price * $quantity;

        foreach ($promotions as $promotion){
            
            $priceModifier = $this -> priceModifierFactory -> create($promotion -> getType());
          
            $modifiedPrice = $priceModifier -> modify($price, $quantity, $promotion, $enquiry);
            if($modifiedPrice < $lowestPrice){

               
                $enquiry -> setDiscountedPrice($modifiedPrice);
                $enquiry -> setPromotionId($promotion -> getId());
                $enquiry -> setPromotionName($promotion -> getName());
                $lowestPrice = $modifiedPrice;
            }

            
        }
        return $enquiry;
    }
}  
