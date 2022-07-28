<?php
namespace App\Filter;


use App\Filter\PromotionFilterInterface;
use App\DTO\PromotionEnquiryInterface;
use App\Entity\Product;
use App\Entity\Promotion;
use App\DTO\LowestPriceEnquiry;

class LowestPriceFilter implements PromotionFilterInterface
{

    public function apply(PromotionEnquiryInterface $enquiry, Promotion ...$promotion): PromotionEnquiryInterface
    {
        $price = $enquiry -> getProduct() -> getPrice();
        $quantity  = $enquiry -> getQuantity();
        $lowestPrice = $price * $quantity;

        
        $modifiedPrice = $priceModifier -> modify($price, $quantity, $promotion, $enquiry);

        $enquiry -> setPrice(100);
        $enquiry -> setDiscountedPrice(250);
        $enquiry -> setPromotionId(3);
        $enquiry -> setPromotionName('Black friday half price sale');

        return $enquiry;
    }
}  
