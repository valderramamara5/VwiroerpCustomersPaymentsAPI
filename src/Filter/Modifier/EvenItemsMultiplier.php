<?php 

namespace App\Filter\Modifier;
use App\Entity\Promotion;
use App\DTO\PromotionEnquiryInterface;

class EvenItemsMultiplier implements PriceModifierInterface
{
    public function modify(int $price, int $quantity, Promotion $promotion, PromotionEnquiryInterface $enquiry): int 
    {
        $minQuantity = $promotion -> getCriteria()["minimum_quantity"];

        if(!($quantity >= $minQuantity)){
            return $quantity * $price;
        }    

        //return (intdiv($quantity, 2) + $quantity%2)*$price;

        // $oddCount = $quantity % 2;
        // $eventCount = $quantity - $oddCount;
        //return ($eventCount * $price * $promotion-> getAdjustment()) + $oddCount*$price;
        
        return (intdiv($quantity, 2)*2*$price * $promotion -> getAdjustment()) + ($quantity%2*$price);
    }

}

    